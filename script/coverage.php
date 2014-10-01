<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\script;

require_once __DIR__ . '/../vendor/autoload.php';

use cloak\Analyzer;
use cloak\ConfigurationBuilder;
use cloak\Result\File;
use cloak\reporter\CompositeReporter;
use cloak\reporter\ProcessingTimeReporter;
use cloak\reporter\TextReporter;
use cloak\reporter\LcovReporter;
use cloak\reporter\MarkdownReporter;
use Symfony\Component\Yaml\Yaml;
use RecursiveDirectoryIterator;
use FilesystemIterator;
use RecursiveIteratorIterator;

$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->reporter(new CompositeReporter([
        new LcovReporter(__DIR__ . '/report.lcov'),
        new MarkdownReporter(__DIR__ . '/report.md'),
        new TextReporter(),
        new ProcessingTimeReporter()
    ]));
    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$directoryIterator = new RecursiveDirectoryIterator(__DIR__ . '/../spec',
    FilesystemIterator::CURRENT_AS_FILEINFO |
    FilesystemIterator::KEY_AS_PATHNAME |
    FilesystemIterator::SKIP_DOTS
);

$filterIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::LEAVES_ONLY);

$targetFiles = [];
$coverageConfig = Yaml::parse(__DIR__ . '/../coverage.yml');
$excludeTargets = $coverageConfig['targets'];

$quotePatterns = array_map(function($excludeTarget) {
    return preg_quote($excludeTarget, DIRECTORY_SEPARATOR);
}, $excludeTargets);

$pattern = '(' . implode('|', $quotePatterns) . ')';

foreach ($filterIterator as $key => $file) {
    if (preg_match("/{$pattern}/", $file->getPathname()) === 1) {
        continue;
    }
    $targetFiles[] = $file;
}

$analyzer->start();

$defaultArgv = array('../vendor/bin/pho', '--stop');
$argv = array_merge($defaultArgv, $targetFiles);

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
