<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle;
use FOS\RestBundle as FOSRestBundle;



class DemoController extends FOSRestBundle\Controller\FOSRestController
{
    public function getUsersAction()
    {
        $view = $this->view(array('foo' => 'bar'), 200)
            ->setTemplate("MyBundle:Users:getUsers.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }
}
