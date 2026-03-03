<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Acme\SyliusExamplePlugin\Controller\GreetingController;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(GreetingController::class)
        ->public()
        ->autowire()
        ->autoconfigure()
    ;
};
