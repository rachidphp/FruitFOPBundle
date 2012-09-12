<?php

namespace Fruit\FOPBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Parser;

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

        $mapping = array();
        $yaml = new Parser();
        foreach ($container->getParameter('kernel.bundles') as $bundleName) {
            $bundleClass = new \ReflectionClass($bundleName);
            $configPath = dirname($bundleClass->getFileName()) . '/Resources/config/fruitfop';

            if (is_dir($configPath)) {
                $handle = opendir($configPath);

                while (false !== ($entry = readdir($handle))) {
                    $parts = pathinfo($entry);
                    if (strtolower($parts['extension']) !== 'yml') {
                        continue;
                    }
                    $mapping = array_merge($mapping, $yaml->parse(file_get_contents($configPath . '/' . $entry)));
                }
                closedir($handle);
            }
        }

        // todo: allow for mapping to exist outside of the bundles

        $container->setParameter('favouritefruit.fop.mapping', $mapping);
    }
}
