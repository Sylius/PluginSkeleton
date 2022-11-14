<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests/Behat',
        __DIR__ . '/ecs.php',
    ]);

    $ecsConfig->import('vendor/sylius-labs/coding-standard/ecs.php');

    $ecsConfig->skip([
        VisibilityRequiredFixer::class => ['*Spec.php'],
    ]);
};

