<?php

use Ibrows\LoggableBundle\Command\ChangeCommand;
use Ibrows\LoggableBundle\Form\ScheduledChangeableTypeExtension;
use Ibrows\LoggableBundle\Util\Changer;
use Ibrows\LoggableBundle\Util\Logger;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();

    $services->set(ChangeCommand::class)
        ->arg(0, service('ibrows_loggable.changer'))
        ->tag('console.command');

    $services->set('ibrows_loggable.changer', Changer::class)
        ->arg(0, service('doctrine.orm.entity_manager'))
        ->arg(1, service('ibrows_loggable.logger'))
        ->arg(2, '%ibrows_loggable.changeable.change_entity_class%')
        ->call('setCatchExceptions', ['%ibrows_loggable.changeable.catch_exception%'])
        ->call('setLogger', [service('logger')]);

    $services->set('ibrows_loggable.logger', Logger::class)
        ->arg(0, service('doctrine.orm.entity_manager'))
        ->arg(1, service('ibrows_loggable.listener'))
        ->call('setLogger', [service('logger')]);

    $services->set('ibrows_loggable.scheduled_changeable_type_extension', ScheduledChangeableTypeExtension::class)
        ->tag('form.type_extension', ['extended-type' => FormType::class]);
};
