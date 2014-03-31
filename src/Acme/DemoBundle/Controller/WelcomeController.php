<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        $c = new \PDO("mysql:host=127.0.0.1;dbname=api-rest", "root", null);
        var_dump($c);
        echo base64_encode(sha1(base64_decode('2') . '2014-03-30 13:25:00' . 'adminpass', true));

        //curl -H 'x-wsse: UsernameToken Username="admin", PasswordDigest="WxAVhdp/wPkpPQ987VgrYR4ItGU=", Nonce="2", Created="2014-03-30 13:25:00"' http://localhost/web/app_dev.php/api/demo/users


       /* $request = new \HttpRequest('http://localhost/demo/demo/users');
        $request->addHeaders(array('x-wsse' => 'UsernameToken Username="user", PasswordDigest="16qSIs0Ft+FlfynZmNCfe8lz6/o=", Nonce="1", Created="2014-03-29'));

        var_dump($request->send()->getBody());*/
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}
