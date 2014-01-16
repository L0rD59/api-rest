<?php

namespace Acme\DemoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection;
use Acme\DemoBundle;

class AcmeDemoBundle extends Bundle
{
    public function build(DependencyInjection\ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new DemoBundle\DependencyInjection\Security\Factory\WsseFactory());
    }
}
