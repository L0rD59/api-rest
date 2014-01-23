<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        echo base64_encode(sha1(base64_decode('1') . '2014-01-23 11:40:00' . 'userpass', true));
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}
