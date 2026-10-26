<?php

declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Filter\TagFilter;
use Behat\Config\Profile;
use Behat\Config\Suite;

// Put your Behat suites definitions here

return (new Config())
    ->withProfile(
        (new Profile('default'))
        ->withSuite(
            (new Suite('greeting_customer'))
            ->withPaths('features')
            ->withContexts('acme_sylius_example.context.ui.shop.welcome')
            ->withFilter(new TagFilter('@greeting_customer')),
        ),
    )
;
