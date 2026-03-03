<?php

declare(strict_types=1);

use Acme\SyliusExamplePlugin\Controller\GreetingController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('acme_sylius_example_static_welcome', '/static-welcome/{name}')
        ->defaults([
            '_controller' => GreetingController::staticallyGreetAction(),
            'name' => null,
        ])
    ;

    $routes->add('acme_sylius_example_dynamic_welcome', '/dynamic-welcome/{name}')
        ->defaults([
            '_controller' => GreetingController::dynamicallyGreetAction(),
            'name' => null,
        ])
    ;
};
