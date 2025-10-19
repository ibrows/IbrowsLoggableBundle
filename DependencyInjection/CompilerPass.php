<?php
/**
 * Created by iBROWS AG.
 * User: marcsteiner
 * Date: 27.02.14
 * Time: 17:12
 */

namespace Ibrows\LoggableBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        $configs = $containerBuilder->getParameter('ibrows_loggable.loggable');
        $logger = $containerBuilder->getDefinition('stof_doctrine_extensions.listener.loggable');

        foreach ($configs as $key => $value) {
            // Convert snake_case to PascalCase for method names
            $methodName = 'set' . str_replace('_', '', ucwords($key, '_'));
            $logger->addMethodCall($methodName, [$value]);
        }

        $containerBuilder
            ->setAlias('ibrows_loggable.listener', 'stof_doctrine_extensions.listener.loggable')
            ->setPublic(true);
    }
}
