<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Tests\Acme\SyliusExamplePlugin\Behat\Context\Ui\Shop\WelcomeContext;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('acme_sylius_example.context.ui.shop.welcome', WelcomeContext::class)
        ->public()
        ->args([
            service('acme_sylius_example.page.shop.static_welcome'),
            service('acme_sylius_example.page.shop.dynamic_welcome'),
        ])
    ;
};
