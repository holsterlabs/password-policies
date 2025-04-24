<?php

namespace Hl\PasswordPolicies;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Hl\PasswordPolicies\DependencyInjection\PasswordPoliciesExtension;

class HlPasswordPoliciesBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    public function getContainerExtension(): ?\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new PasswordPoliciesExtension();
    }
}