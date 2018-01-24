<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->in(__DIR__.'/src')
    ->name('*.php')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'ordered_imports' => true,
        'strict_comparison' => true,
        'array_syntax' => ['syntax' => 'short'],
        'phpdoc_add_missing_param_annotation' => true,
    ])
    ->setFinder($finder)
;
