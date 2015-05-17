<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


namespace Example;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/src/functions.php";

use cloak\CoverageAnalyzer;
use cloak\configuration\ConfigurationBuilder;


use Example as example;

$builder = new ConfigurationBuilder();

$builder->includeFile('/example/src')
    ->excludeFile('/spec');

$analyzer = new CoverageAnalyzer( $builder->build() );
$analyzer->start();

//I write code here want to take code coverage
example\example1();

$analyzer->stop();

$files = $analyzer->getResult()->getFiles();

foreach ($files as $file) {
    $result = sprintf("%s > %6.2f%% (%d/%d)",
        $file->getName(),
        $file->getCodeCoverage()->value(),
        $file->getExecutedLineCount(),
        $file->getExecutableLineCount()
    );
    echo $result . "\n";
}
