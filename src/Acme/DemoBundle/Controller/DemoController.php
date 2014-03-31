<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle;
use FOS\RestBundle as FOSRestBundle;


class DemoController extends FOSRestBundle\Controller\FOSRestController implements FOSRestBundle\Routing\ClassResourceInterface
{
    /**
     * @FOSRestBundle\Controller\Annotations\QueryParam(name="email", requirements="\d+", description="Email of users")
     * @FOSRestBundle\Controller\Annotations\QueryParam(name="sort", requirements="\d+", description="Sort of users")
     * @FOSRestBundle\Controller\Annotations\QueryParam(name="limit", requirements="\d+", description="Limit of users")
     * @return \Symfony\Component\HttpFoundation\Response
     * @FOSRestBundle\Controller\Annotations\View()
     */
    public function getUsersAction()
    {
        $view = $this->view(array('foo' => 'bar'), 200);

        return $this->handleView($view);
    }
}
