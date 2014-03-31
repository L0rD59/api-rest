<?php
namespace Acme\DemoBundle\Security\Authentication\Provider;

use Symfony\Component\Security;
use Acme\DemoBundle as AcmeDemoBundle;

class WsseProvider implements Security\Core\Authentication\Provider\AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;
    private $lifetime;

    public function __construct(Security\Core\User\UserProviderInterface $userProvider, $cacheDir, $lifetime)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir = $cacheDir;
        $this->lifetime = $lifetime;
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
        // Expire le timestamp après lifetime
        if (time() - strtotime($created) > $this->lifetime) {
            return false;
        }

        // Valide que le nonce est unique dans les 5 minutes
        if (file_exists($this->cacheDir . '/' . $nonce) && file_get_contents(
                $this->cacheDir . '/' . $nonce
            ) + $this->lifetime < time()
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