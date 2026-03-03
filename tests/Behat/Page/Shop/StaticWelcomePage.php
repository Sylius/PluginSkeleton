<?php

declare(strict_types=1);

namespace Tests\Acme\SyliusExamplePlugin\Behat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class StaticWelcomePage extends SymfonyPage implements WelcomePageInterface
{
    public function getGreeting(): string
    {
        return $this->getElement('greeting')->getText();
    }

    public function getRouteName(): string
    {
        return 'acme_sylius_example_static_welcome';
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'greeting' => '[data-test-static-greeting]',
        ]);
    }
}
