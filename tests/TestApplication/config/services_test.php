<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    if (str_starts_with($container->env(), 'test')) {
        // Sylius 2.3+ ships its Behat services as PHP, older versions as XML
        $syliusBehatServices = '../../../vendor/sylius/sylius/src/Sylius/Behat/Resources/config/services';
        $container->import(is_file(__DIR__ . '/' . $syliusBehatServices . '.php') ? $syliusBehatServices . '.php' : $syliusBehatServices . '.xml');
        $container->import('@AcmeSyliusExamplePlugin/tests/Behat/Resources/services.php');
    }
};
