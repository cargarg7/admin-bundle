<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AdminElementPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('admin.manager')
            || !$container->has('admin.manager.visitor.element_collection')
        ) {
            return;
        }

        $elements = [];
        $elementServices = $container->findTaggedServiceIds('admin.element');
        foreach (array_keys($elementServices) as $id) {
            $elements[] = new Reference($id);
        }

        $container->findDefinition('admin.manager.visitor.element_collection')
            ->replaceArgument(0, $elements);
    }
}
