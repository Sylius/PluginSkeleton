<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('sylius_twig_hooks', [
        'hooks' => [
            'app_shop.greeting.dynamic' => [
                'content' => [
                    'template' => '@AcmeSyliusExamplePlugin/shop/greeting/dynamic/content.html.twig',
                    'priority' => 0,
                ],
            ],
            'app_shop.greeting.static' => [
                'content' => [
                    'template' => '@AcmeSyliusExamplePlugin/shop/greeting/static/content.html.twig',
                    'priority' => 0,
                ],
            ],
        ],
    ]);
};
