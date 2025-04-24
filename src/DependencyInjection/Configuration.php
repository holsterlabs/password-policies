<?php

namespace Hl\PasswordPolicies\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hl_password_policies');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('password_policies')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->integerNode('minimumLength')->defaultValue(8)->end()
                            ->arrayNode('options')
                                ->children()
                                    ->integerNode('digitCharacterRequired')->end()
                                    ->integerNode('lowerCaseCharacterRequired')->end()
                                    ->integerNode('upperCaseCharacterRequired')->end()
                                    ->integerNode('specialCharacterRequired')->end()
                                ->end()
                            ->end()
                            ->integerNode('charakterVariance')->defaultValue(3)->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
