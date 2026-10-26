<?php

declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Extension;
use Behat\Config\Profile;
use Behat\MinkExtension\ServiceContainer\MinkExtension;
use DMore\ChromeExtension\Behat\ServiceContainer\ChromeExtension;
use FriendsOfBehat\MinkDebugExtension\ServiceContainer\MinkDebugExtension;
use FriendsOfBehat\SymfonyExtension\ServiceContainer\SymfonyExtension;
use FriendsOfBehat\VariadicExtension\ServiceContainer\VariadicExtension;
use SyliusLabs\SuiteTagsExtension\ServiceContainer\SuiteTagsExtension;

// Sylius 2.3+ ships its Behat suites as PHP, older versions as YAML
$syliusSuitesPath = 'vendor/sylius/sylius/src/Sylius/Behat/Resources/config/suites';

return (new Config())
    ->import([
        is_file(__DIR__ . '/' . $syliusSuitesPath . '.php') ? $syliusSuitesPath . '.php' : $syliusSuitesPath . '.yml',
        'tests/Behat/Resources/suites.php',
    ])
    ->withProfile(
        (new Profile('default', [
            'formatters' => [
                'pretty' => [
                    'verbose' => true,
                    'paths' => false,
                    'snippets' => false,
                ],
            ],
        ]))
        ->withExtension(new Extension(ChromeExtension::class))
        ->withExtension(new Extension(MinkDebugExtension::class, [
            'directory' => 'etc/build',
            'clean_start' => false,
            'screenshot' => true,
        ]))
        ->withExtension(new Extension(MinkExtension::class, [
            'files_path' => '%paths.base%/vendor/sylius/sylius/src/Sylius/Behat/Resources/fixtures/',
            'base_url' => '%env(BEHAT_BASE_URL)%',
            'default_session' => 'symfony',
            'javascript_session' => 'chrome',
            'sessions' => [
                'symfony' => [
                    'symfony' => null,
                ],
                'chrome' => [
                    'chrome' => [
                        'api_url' => 'http://127.0.0.1:9222',
                        'validate_certificate' => false,
                    ],
                ],
            ],
            'show_auto' => false,
        ]))
        ->withExtension(new Extension(SymfonyExtension::class, [
            'bootstrap' => 'vendor/sylius/test-application/config/bootstrap.php',
            'kernel' => [
                'class' => 'Sylius\TestApplication\Kernel',
                'environment' => 'test',
            ],
        ]))
        ->withExtension(new Extension(VariadicExtension::class))
        ->withExtension(new Extension(SuiteTagsExtension::class)),
    )
;
