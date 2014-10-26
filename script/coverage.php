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
use cloak\ConfigurationLoader;
use Symfony\Component\Yaml\Yaml;
use RecursiveDirectoryIterator;
use FilesystemIterator;
use RecursiveIteratorIterator;


$loader = new ConfigurationLoader();
$configuration = $loader->loadConfigration('cloak.toml');
$analyzer = new Analyzer($configuration);

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
    $pathName = $file->getPathname();

    if (preg_match("/{$pattern}/", $pathName) === 1) {
        continue;
    }

    if (preg_match("/.+Spec\.php$/", $pathName) === 0) {
        continue;
    }

    $targetFiles[] = $file;
}

$analyzer->start();

$defaultArgv = array('../vendor/bin/pho', '--stop');
$argv = array_merge($defaultArgv, $targetFiles);

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
