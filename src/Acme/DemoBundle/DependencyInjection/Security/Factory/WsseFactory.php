<?php
namespace Acme\DemoBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection;
use Symfony\Component\Config;
use Symfony\Bundle\SecurityBundle;

class WsseFactory implements SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface
{
    public function create(DependencyInjection\ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.wsse.' . $id;
        $container
            ->setDefinition($providerId, new DependencyInjection\DefinitionDecorator('wsse.security.authentication.provider'))
            ->replaceArgument(0, new DependencyInjection\Reference($userProvider))
            ->replaceArgument(2, $config['lifetime']);

        $listenerId = 'security.authentication.listener.wsse.' . $id;
        $listener = $container->setDefinition(
            $listenerId,
            new DependencyInjection\DefinitionDecorator('wsse.security.authentication.listener')
        );

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'wsse';
    }

    public function addConfiguration(Config\Definition\Builder\NodeDefinition $node)
    {
        $node
            ->children()
            ->scalarNode('lifetime')->defaultValue(300)
            ->end();
    }
}