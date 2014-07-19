<?php

use phake\Application;

group('example', function() {
    desc('Run the example program basic');
    task('basic', function() {
        require_once __DIR__ . '/example/basic_example.php';
    });
});

group('test', function() {

    desc('Run unit tests');
    task('unit', function() {
        $output = [];
        $command = './vendor/bin/pho';
        exec($command, $output, $status);
        echo implode("\n", array_merge($output, array("")));
        exit($status);
    });

    desc('Print a report of code coverage');
    task('coverage', function() {
        $output = [];
        $command = 'php script/coverage.php';
        exec($command, $output, $status);
        echo implode("\n", array_merge($output, array("")));
        exit($status);
    });

    desc('Sent a report of code coverage');
    task('coveralls', function() {
        $output = [];
        $command = 'php script/coveralls.php';
        exec($command, $output, $status);
        echo implode("\n", array_merge($output, array("")));
        exit($status);
    });

});
