<?php
namespace Acme\DemoBundle\Security\Firewall;

use Symfony\Component\Security;
use Symfony\Component\HttpKernel;
use Acme\DemoBundle as AcmeDemoBundle;

class WsseListener implements Security\Http\Firewall\ListenerInterface
{
    protected $securityContext;

    protected $authenticationManager;

    public function __construct(
        Security\Core\SecurityContextInterface $securityContext,
        Security\Core\Authentication\AuthenticationManagerInterface $authenticationManager
    )
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(HttpKernel\Event\GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $wsseRegex = '/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([^"]+)", Created="([^"]+)"/';
        if (!$request->headers->has('x-wsse') || 1 !== preg_match($wsseRegex, $request->headers->get('x-wsse'), $matches)) {
            return;
        }

        $token = new AcmeDemoBundle\Security\Authentication\Token\WsseUserToken();
        $token->setUser($matches[1]);

        $token->digest   = $matches[2];
        $token->nonce    = $matches[3];
        $token->created  = $matches[4];

        try {
            $authToken = $this->authenticationManager->authenticate($token);

            $this->securityContext->setToken($authToken);
        } catch (Security\Core\Exception\AuthenticationException $failed) {
            // ... you might log something here

            // To deny the authentication clear the token. This will redirect to the login page.
            // $this->securityContext->setToken(null);
            // return;

            // Deny authentication with a '403 Forbidden' HTTP response
            $response = new Response();
            $response->setStatusCode(403);
            $event->setResponse($response);

        }
    }
}