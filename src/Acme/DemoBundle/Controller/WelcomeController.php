<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        $request = new \HttpRequest('http://api-rest.local/web/app_dev.php/demo/users');
        $request->addHeaders(array('x-wsse' => 'UsernameToken Username="test", PasswordDigest="test", Nonce="test", Created="2014-01-16"'));

        var_dump($request->send()->getBody());
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}
