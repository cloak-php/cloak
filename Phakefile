<?php

group('example', function() {
    desc('Run the example program basic');
    task('basic', function() {
        require_once __DIR__ . '/example/basic_example.php';
    });
});

group('test', function() {

    desc('Run unit tests');
    task('unit', function() {
        echo shell_exec('./vendor/bin/pho');
    });

    desc('Print a report of code coverage');
    task('coverage', function() {
        echo shell_exec('php script/coverage.php');
    });

});
