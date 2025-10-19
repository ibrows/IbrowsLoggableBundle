<?php

namespace Ibrows\LoggableBundle;

use Ibrows\LoggableBundle\DependencyInjection\CompilerPass;
use Ibrows\LoggableBundle\Listener\LoggableListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IbrowsLoggableBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new CompilerPass());
    }

    /**
     * LoggableListener as last listener
     * Ensures the LoggableListener runs after all other onFlush listeners
     */
    public function boot(): void
    {
        $eventManager = $this->container->get('doctrine')->getManager()->getEventManager();
        $allListeners = $eventManager->getListeners('onFlush');

        foreach ($allListeners as $listener) {
            if ($listener instanceof LoggableListener) {
                $eventManager->removeEventListener('onFlush', $listener);
                $eventManager->addEventListener('onFlush', $listener);
            }
        }
    }
}
