<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__ . "/../vendor/autoload.php";

use cloak\Analyzer;
use cloak\ConfigurationBuilder;
use cloak\Result\File;
use cloak\reporter\TextReporter;
use Symfony\Component\Yaml\Yaml;

$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->reporter(new TextReporter());
    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$analyzer->start();


$defaultArgv = array('../vendor/bin/pho');
$coverageConfig = Yaml::parse(__DIR__ . '/../coverage.yml');
$argv = array_merge($defaultArgv, $coverageConfig['targets']);

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
