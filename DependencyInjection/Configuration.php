<?php

namespace Fruit\FOPBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fruit_fop');
        $rootNode
            ->children()
                ->scalarNode('target_filesystem')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('temp_filesystem')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('temp_directory')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
