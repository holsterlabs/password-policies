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
                            ->arrayNode('checkCharacters')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->integerNode('digitCharacter')->defaultValue(1)->end()
                                    ->integerNode('lowerCaseCharacter')->defaultValue(1)->end()
                                    ->integerNode('upperCaseCharacter')->defaultValue(1)->end()
                                    ->integerNode('specialCharacter')->defaultValue(1)->end()
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