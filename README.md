CodeAnalyzer
=============================

[![Build Status](https://travis-ci.org/holyshared/code-analyzer.png?branch=master)](https://travis-ci.org/holyshared/code-analyzer)
[![Stories in Ready](https://badge.waffle.io/holyshared/code-analyzer.png?label=ready&title=Ready)](https://waffle.io/holyshared/code-analyzer)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/holyshared/code-analyzer/badges/quality-score.png?s=bff77b48e6f3a15bad8f2e8e0153bb5e45e28cae)](https://scrutinizer-ci.com/g/holyshared/code-analyzer/)

CodeAnalyzer is a library that takes a code coverage.  
This library works with **PHP5.4 or more**.

Required modules
------------------------------------------------
* xdebug >= **2.2.2**

How to use
------------------------------------------------

### Setup for the report of code coverage

Setup is required to take a code coverage.  
Run the **configure** method to be set up.

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


### Take the code coverage

Run the start / stop at the place where want to take the code coverage.  
After you can get the report, you need to run the **getResult** method.

	$analyzer->start();

	//I write code here want to take code coverage
	example\example1();

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

How to run the test
------------------------------------------------

### Run only unit test

	vendor/bin/phake test:unit

### Run the code coverage display and unit test

	vendor/bin/phake test:coverage

How to run the example
------------------------------------------------

	vendor/bin/phake example:basic
