<?php

group('example', function() {
    desc('Run the example program basic');
    task('basic', function() {
        require_once __DIR__ . '/example/basic_example.php';
    });
});

group('test', function() {

    desc('Run unit tests');
    task('php_unit', function() {
        $output = [];
        $command = './vendor/bin/pho';
        exec($command, $output, $status);
        echo implode("\n", array_merge($output, array("")));
        exit($status);
    });

    desc('Run unit tests');
    task('hhvm_unit', function() {
        $output = [];
        $command = './vendor/bin/phpspec run spec/hhvm/Driver/HHVMDriverSpec.php';
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

});
