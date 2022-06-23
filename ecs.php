<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import('vendor/sylius-labs/coding-standard/ecs.php');

    $ecsConfig->parameters()->set(Option::SKIP, [
        VisibilityRequiredFixer::class => ['*Spec.php'],
    ]);
};
