<?php

namespace Example;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/src/functions.php";

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Result\File;

use Example as example;

$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->includeFile(function(File $file) {
        return $file->matchPath('/example/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec');
    });

});

$analyzer->start();

//I write code here want to take code coverage
example\example1();

$analyzer->stop();

$files = $analyzer->getResult()->getFiles();

foreach ($files as $file) {
    $result = sprintf("%s > %6.2f%% (%d/%d)",
        $file->getPath(),
        $file->getCodeCoverage()->valueOf(),
        $file->getExecutedLineCount(),
        $file->getExecutableLineCount()
    );
    echo $result . "\n";
}