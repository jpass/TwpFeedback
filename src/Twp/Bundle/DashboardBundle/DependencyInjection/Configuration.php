<?php

namespace Twp\Bundle\DashboardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('twp_dashboard');

        $rootNode
            ->children()
                ->scalarNode('rss_feed')
                    ->defaultValue(false)
                    ->info('rss feed url to parse and load in right bar')
                    ->example('http://emaple.org/?feed=rss')
                    ->end()
            ->end();


        return $treeBuilder;
    }
}
