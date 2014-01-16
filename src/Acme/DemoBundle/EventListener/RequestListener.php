<?php

namespace Acme\DemoBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Acme\DemoBundle\Twig\Extension\DemoExtension;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        //$event->getRequest()->setFormat('yml', 'text/yaml');
    }
}
