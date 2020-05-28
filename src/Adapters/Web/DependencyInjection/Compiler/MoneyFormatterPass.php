<?php

namespace BelkinDom\Adapters\Web\DependencyInjection\Compiler;

use BelkinDom\Adapters\Web\View\MoneyFormatter\MoneyFormatter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MoneyFormatterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(MoneyFormatter::class)) {
            return;
        }

        $definition = $container->findDefinition(MoneyFormatter::class);

        $taggedServices = $container->findTaggedServiceIds('app.view.money_formatter');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addFormatter', [new Reference($id)]);
        }
    }
}
