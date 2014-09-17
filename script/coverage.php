<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\script;

require_once __DIR__ . '/../vendor/autoload.php';


use cloak\Analyzer;
use cloak\ConfigurationBuilder;
use cloak\Result\File;
use cloak\reporter\CompositeReporter;
use cloak\reporter\LcovReporter;
use cloak\reporter\ProcessingTimeReporter;
use cloak\reporter\TextReporter;


$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $reporter = new CompositeReporter([
        new LcovReporter(__DIR__ . '/report.lcov'),
        new TextReporter(),
        new ProcessingTimeReporter()
    ]);

    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        $matchExcludeTarget = $file->matchPath('/spec') || $file->matchPath('/vendor');
        return $matchExcludeTarget;
    })->reporter($reporter);

});

$analyzer->start();

$argv = ['../vendor/bin/pho', '--stop'];
require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
