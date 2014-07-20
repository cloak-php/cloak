<?php

require_once __DIR__ . "/../vendor/autoload.php";

use cloak\Analyzer;
use cloak\ConfigurationBuilder;
use cloak\Result\File;
use cloak\reporter\TextReporter;

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

$argv = array_merge($defaultArgv, array(
    'spec/ConfigurationSpec.php',
    'spec/ConfigurationBuilderSpec.php',
    'spec/ResultSpec.php',
    'spec/result/FileSpec.php',
    'spec/result/LineSpec.php',
    'spec/result/CoverageSpec.php',
    'spec/reporter/ReportableSpec.php',
    'spec/reporter/TextReporterSpec.php',
    'spec/ProgressNotifierSpec.php',
    'spec/AnalyzerSpec.php',
    'spec/DriverDetectorSpec.php',
));

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
