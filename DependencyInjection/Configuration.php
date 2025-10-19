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
                ->booleanNode('catch_exception')->defaultFalse()->end()
                ->scalarNode('change_entity_class')->defaultValue('Ibrows\LoggableBundle\Entity\ChangeSet')->end()
            ->end()->end()
            ->arrayNode('loggable')->addDefaultsIfNotSet()->children()
                ->scalarNode('default_log_entry_class')->defaultValue('Ibrows\LoggableBundle\Entity\Log')->end()
                ->scalarNode('log_parent_entry_class')->defaultValue('Ibrows\LoggableBundle\Entity\LogMany2Many')->end()
                ->scalarNode('log_collection_entry_class')->defaultValue('Ibrows\LoggableBundle\Entity\LogParent')->end()
                ->booleanNode('enabled')->defaultTrue()->end()
                ->booleanNode('use_only_single_ids')->defaultTrue()->end()
                ->booleanNode('default_all_versioned')->defaultTrue()->end()
            ->end()->end()
        ->end();

        return $treeBuilder;
    }
}