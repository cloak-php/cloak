<?php

require_once __DIR__ . "/vendor/autoload.php";

use CodeAnalyzer\CodeAnalyzer;
use CodeAnalyzer\Configuration;
use CodeAnalyzer\Result\File;

CodeAnalyzer::configure(function(Configuration $configuration) {

    $configuration->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })
    ->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$analyzer = new CodeAnalyzer();
$analyzer->start();

$defaultArgv = array('./vendor/bin/pho', '--reporter', 'spec');

$argv = array_merge($defaultArgv, array(
    'spec/ConfigurationSpec.php',
    'spec/ResultSpec.php',
    'spec/Result/FileSpec.php',
    'spec/Result/LineSpec.php'
));

require_once __DIR__ . "/vendor/bin/pho";

$analyzer->stop();

$result = $analyzer->getResult()->getFiles();

foreach ($result as $file) {
    $result = sprintf("%s > %0.2f%% (%d/%d)",
        $file->getPath(),
        $file->getCodeCoverage(),
        $file->getExecutedLineCount(),
        $file->getExecutableLineCount()
    );
    echo $result . "\n";
}
