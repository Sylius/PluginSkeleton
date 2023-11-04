<?php

declare(strict_types=1);

namespace Clictec\Bundle\ExampleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ClictecExampleBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
