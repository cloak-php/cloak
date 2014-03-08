*<?php

require_once __DIR__ . "/vendor/autoload.php";

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\Configuration;
use CodeAnalyzer\Result\File;
use CodeAnalyzer\Reporter\TextReporter;

$analyzer = new Analyzer();
$analyzer->start();

$defaultArgv = array('./vendor/bin/pho', '--reporter', 'spec');

$argv = array_merge($defaultArgv, array(
    'spec/ConfigurationSpec.php',
    'spec/ResultSpec.php',
    'spec/Result/FileSpec.php',
    'spec/Result/LineSpec.php',
    'spec/AnalyzerSpec.php'
));

require_once __DIR__ . "/vendor/bin/pho";

$analyzer->stop();

$result = $analyzer->getResult();
$result = $result->includeFile(function(File $file) {
    return $file->matchPath('/src');
})
->excludeFile(function(File $file) {
    return $file->matchPath('/spec') || $file->matchPath('/vendor');
});

$reporter = new TextReporter();
$reporter->stop($result);
