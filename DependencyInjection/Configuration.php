<?php

namespace Zaeder\Link4MailingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zaeder_link4mailing');

        $rootNode
            ->children()
                ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('firewall_name')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}