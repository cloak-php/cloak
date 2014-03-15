*<?php

require_once __DIR__ . "/../vendor/autoload.php";

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Result\File;
use CodeAnalyzer\Reporter\TextReporter;
use Zend\EventManager\Event;

$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

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
    'spec/ResultSpec.php',
    'spec/Result/FileSpec.php',
    'spec/Result/LineSpec.php',
    'spec/Result/CoverageSpec.php',
    'spec/Reporter/TextReporterSpec.php',
    'spec/AnalyzerSpec.php'
));

require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();

$result = $analyzer->getResult();

$event = new Event('stop', $analyzer, [ 'result' => $result ]);

$reporter = new TextReporter();
$reporter->onStop($event);
