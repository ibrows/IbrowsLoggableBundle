<?php

namespace Ibrows\LoggableBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ibrows_loggable');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->arrayNode('changeable')->addDefaultsIfNotSet()->children()
                ->booleanNode('CatchException')->defaultFalse()->end()
                ->scalarNode('ChangeEntityClass')->defaultValue('Ibrows\LoggableBundle\Entity\ChangeSet')->end()
            ->end()->end()
            ->arrayNode('loggable')->addDefaultsIfNotSet()->children()
                ->scalarNode('DefaultLogEntryClass')->defaultValue('Ibrows\LoggableBundle\Entity\Log')->end()
                ->scalarNode('LogParentEntryClass')->defaultValue('Ibrows\LoggableBundle\Entity\LogMany2Many')->end()
                ->scalarNode('LogCollectionEntryClass')->defaultValue('Ibrows\LoggableBundle\Entity\LogParent')->end()
                ->booleanNode('Enabled')->defaultTrue()->end()
                ->booleanNode('UseOnySingleIds')->defaultTrue()->end()
                ->booleanNode('DefaultAllVersioned')->defaultTrue()->end()
            ->end()->end()
        ->end();

        return $treeBuilder;
    }
}