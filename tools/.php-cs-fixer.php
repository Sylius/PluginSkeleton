<?php

$finder = (new PhpCsFixer\Finder())
    ->in(\dirname(__DIR__) . '/{src,tests}')
    ->notName('tests/Kernel.php')
       ->exclude('/')
   
;

return (new PhpCsFixer\Config())
    ->setUsingCache(true)
    ->setCacheFile('.php-cs-fixer.cache')
    ->setRules([
        '@PhpCsFixer' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        '@PHP73Migration' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'comment_to_phpdoc' => true,
        'declare_strict_types' => true,
        // 'final_class' => true,
        'header_comment' => ['header' => ''],
        'heredoc_to_nowdoc' => true,
        'increment_style' => false,
        'list_syntax' => ['syntax' => 'short'],
        'mb_str_functions' => true,
        'method_chaining_indentation' => false,
        'modernize_types_casting' => true,
        'multiline_whitespace_before_semicolons' => false,
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced'],
        'non_printable_character' => ['use_escape_sequences_in_strings' => true],
        'no_superfluous_phpdoc_tags' => false,
        'operator_linebreak' => ['only_booleans' => true, 'position' => 'end'],
        'ordered_class_elements' => true,
        'ordered_imports' => ['imports_order' => ['const', 'class', 'function']],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => true],
        'phpdoc_order' => true,
        'phpdoc_no_package' => false,
        'phpdoc_summary' => false,
        'phpdoc_to_comment' => false,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
        'php_unit_test_class_requires_covers' => false,
        'protected_to_private' => true,
        'self_accessor' => false,
        'single_line_throw' => false,
        'types_spaces' => false,
        'yoda_style' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
