<?php
namespace Acme\DemoBundle\Security\Authentication\Token;

use Symfony\Component\Security;

class WsseUserToken extends Security\Core\Authentication\Token\AbstractToken
{
    public $createdAt;

    public $digest;

    public $nonce;

    public function __construct(array $roles = array())
    {
        parent::__construct($roles);
        // Si l'utilisateur a des rôles, on le considère comme authentifié
        $this->setAuthenticated(count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }
} 