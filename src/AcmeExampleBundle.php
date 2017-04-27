<?php

namespace Acme\ExampleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;

final class AcmeExamplePlugin extends Bundle
{
    use SyliusPluginTrait;
}
