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
//use coverallskit\ReportBuilder;
use coverallskit\entity\service\Travis;
use coverallskit\entity\Repository;
use coverallskit\entity\Coverage;
use coverallskit\entity\SourceFile;
use coverallskit\exception\LineOutOfRangeException;

use coverallskit\ConfigurationLoader;
use coverallskit\ReportBuilderFactory;


$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$analyzer->start();


$defaultArgv = array('../vendor/bin/pho');

$argv = array_merge($defaultArgv, array(
    'spec/ConfigurationSpec.php',
    'spec/ConfigurationBuilderSpec.php',
    'spec/ResultSpec.php',
    'spec/result/FileSpec.php',
    'spec/result/LineSpec.php',
    'spec/result/CoverageSpec.php',
    'spec/reporter/ReportableSpec.php',
    'spec/reporter/TextReporterSpec.php',
    'spec/AnalyzeLifeCycleNotifierSpec.php',
    'spec/AnalyzerSpec.php',
    'spec/DriverDetectorSpec.php',
));

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();


$builderFactory = new ReportBuilderFactory(new ConfigurationLoader);
$builder = $builderFactory->createFromConfigurationFile(__DIR__ . '/../coveralls.yml');

$fileResults = $analyzer->getResult()->getFiles();

foreach ($fileResults as $fileResult) {

    $source = new SourceFile($fileResult->getPath());

    $lineCoverages = $fileResult->getLines();

    foreach ($lineCoverages as $lineCoverage) {
        $lineAt = $lineCoverage->getLineNumber();

        try {
            if ($lineCoverage->isExecuted()) {
                $source->addCoverage(Coverage::executed($lineAt));
            } else if ($lineCoverage->isUnused()) {
                $source->addCoverage(Coverage::unused($lineAt));
            }
        } catch (LineOutOfRangeException $exception) {
            echo $source->getName() . PHP_EOL;
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    $builder->addSource($source);

}

$builder->build()->save()->upload();
