<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('brandcode_nl_sonata_mailchimp_publisher');
            
        
        $rootNode
            ->children()                
                ->scalarNode('api_key')
                    ->isRequired()
                ->end()
                ->arrayNode('lists')
                    ->useAttributeAsKey('listId')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('fromName')->end()
                            ->scalarNode('fromEmail')->end()
                            ->scalarNode('template')->end()
                            ->scalarNode('format')->end()
                            ->scalarNode('api_key')->end()
                        ->end()
                    ->end() 
                ->end()
            ->end();

        return $treeBuilder;
    }
}
