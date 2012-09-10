<?php

namespace Fruit\FOPBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class FruitFOPExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('fop.xml');

        $container->setAlias('favouritefruit.fop.target_filesystem', $config['target_filesystem']);
        $container->setAlias('favouritefruit.fop.temp_filesystem', $config['temp_filesystem']);
        $container->setParameter('favouritefruit.fop.temp_directory', $config['temp_directory']);
    }
}
