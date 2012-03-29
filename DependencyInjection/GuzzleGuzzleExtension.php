<?php

namespace Guzzle\GuzzleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Definition\Processor;

class GuzzleGuzzleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');
        
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

//        $serviceBuilderConfigFile = $config['service_builder']['configuration_file'];
//        if(!file_exists($serviceBuilderConfigFile)){
//            throw new \InvalidArgumentException('Configuration file '.$serviceBuilderConfigFile.' doesn\'t exists');
//        }
        
        $container->setParameter('guzzle.service_builder.configuration_file', $config['service_builder']['configuration_file']);
        
    }
}