<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Tests\Acme\SyliusExamplePlugin\Behat\Page\Shop\DynamicWelcomePage;
use Tests\Acme\SyliusExamplePlugin\Behat\Page\Shop\StaticWelcomePage;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('acme_sylius_example.page.shop.static_welcome', StaticWelcomePage::class)
        ->parent('sylius.behat.symfony_page')
    ;

    $services->set('acme_sylius_example.page.shop.dynamic_welcome', DynamicWelcomePage::class)
        ->parent('sylius.behat.symfony_page')
    ;
};
