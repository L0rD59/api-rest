<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle;
use FOS\RestBundle as FOSRestBundle;
use FOS\RestBundle\Controller\Annotations\View;


class DemoController extends FOSRestBundle\Controller\FOSRestController implements FOSRestBundle\Routing\ClassResourceInterface
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View()
     */
    public function getUsersAction()
    {
        $view = $this->view(array('foo' => 'bar'), 200);

        return $this->handleView($view);
    }
}
