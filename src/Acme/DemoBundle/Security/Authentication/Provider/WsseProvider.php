<?php
namespace Acme\DemoBundle\Security\Authentication\Provider;

use Symfony\Component\Security;
use Acme\DemoBundle as AcmeDemoBundle;

class WsseProvider implements Security\Core\Authentication\Provider\AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    public function __construct(Security\Core\User\UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir = $cacheDir;
    }

    public function authenticate(Security\Core\Authentication\Token\TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
            $authenticatedToken = new AcmeDemoBundle\Security\Authentication\Token\WsseUserToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new Security\Core\Exception\AuthenticationException('The WSSE authentication failed.');
    }

    protected function validateDigest($digest, $nonce, $created, $secret)
    {
        // Expire le timestamp après 5 minutes
        if (time() - strtotime($created) > 300) {
            return false;
        }

        // Valide que le nonce est unique dans les 5 minutes
        if (file_exists($this->cacheDir . '/' . $nonce) && file_get_contents(
                $this->cacheDir . '/' . $nonce
            ) + 300 > time()
        ) {
            throw new Security\Core\Exception\NonceExpiredException('Previously used nonce detected');
        }
        file_put_contents($this->cacheDir . '/' . $nonce, time());

        // Valide le Secret
        $expected = base64_encode(sha1(base64_decode($nonce) . $created . $secret, true));

        return $digest === $expected;
    }

    public function supports(Security\Core\Authentication\Token\TokenInterface $token)
    {
        return $token instanceof AcmeDemoBundle\Security\Authentication\Token\WsseUserToken;
    }
}