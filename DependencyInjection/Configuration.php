<?php

namespace Guzzle\GuzzleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('guzzle');
        
        $rootNode
            ->children()
                ->arrayNode('service_builder')
                    ->children()
                        ->scalarNode('class')->defaultValue('Guzzle\Service\ServiceBuilder')->end()
                        ->scalarNode('configuration_file')->defaultValue('%kernel.root_dir%/config/guzzleclients.xml')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;                        
    }
}