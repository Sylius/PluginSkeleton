<?php

declare(strict_types=1);

namespace Acme\SyliusExamplePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AcmeSyliusExamplePlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
