<?php

require_once __DIR__ . "/../vendor/autoload.php";

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Result\File;
use CodeAnalyzer\Reporter\TextReporter;

$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->reporter(new TextReporter());
    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$analyzer->start();

$defaultArgv = array('../vendor/bin/pho', '--reporter', 'spec');

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
