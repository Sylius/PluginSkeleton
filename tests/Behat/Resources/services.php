<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Tests\Acme\SyliusExamplePlugin\Behat\Context\Ui\Shop\WelcomeContext;
use Tests\Acme\SyliusExamplePlugin\Behat\Page\Shop\DynamicWelcomePage;
use Tests\Acme\SyliusExamplePlugin\Behat\Page\Shop\StaticWelcomePage;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->defaults()
        ->public()
    ;

    // Put your Behat services here

    $services->set('acme_sylius_example.context.ui.shop.welcome', WelcomeContext::class)
        ->args([
            service('acme_sylius_example.page.shop.static_welcome'),
            service('acme_sylius_example.page.shop.dynamic_welcome'),
        ])
    ;

    $services->set('acme_sylius_example.page.shop.static_welcome', StaticWelcomePage::class)
        ->parent('sylius.behat.symfony_page')
        ->private()
    ;

    $services->set('acme_sylius_example.page.shop.dynamic_welcome', DynamicWelcomePage::class)
        ->parent('sylius.behat.symfony_page')
        ->private()
    ;
};
