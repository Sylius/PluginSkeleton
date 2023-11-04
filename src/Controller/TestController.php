<?php

declare(strict_types=1);

namespace Clictec\Bundle\ExampleBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

final class TestController
{
    public function staticallyGreetAction(?string $name): Response
    {
        return new Response(sprintf('Hello <strong>%s</strong>!', $name));
    }
}
