<?php

require_once __DIR__ . "/../vendor/autoload.php";

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Result\File;
use coverallskit\JSONFileBuilder;
use coverallskit\entity\service\Travis;
use coverallskit\entity\Repository;
use coverallskit\entity\Coverage;
use coverallskit\entity\SourceFile;
use coverallskit\exception\LineOutOfRangeException;


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
    'spec/Result/FileSpec.php',
    'spec/Result/LineSpec.php',
    'spec/Result/CoverageSpec.php',
    'spec/Reporter/ReportableSpec.php',
    'spec/Reporter/TextReporterSpec.php',
    'spec/ProgressNotifierSpec.php',
    'spec/AnalyzerSpec.php'
));

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();


$builder = new JSONFileBuilder();
$builder->token('8CFNrlGgXsDPPR8r03VnIXJl6cCVnDhcO')
    ->service(Travis::travisCI())
    ->repository(new Repository(__DIR__ . '/../'));

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

$builder->build()->saveAs(__DIR__ . '/coverage.json')->upload();

