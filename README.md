CodeAnalyzer
=============================

[![Build Status](https://travis-ci.org/holyshared/code-analyzer.png?branch=master)](https://travis-ci.org/holyshared/code-analyzer)
[![Stories in Ready](https://badge.waffle.io/holyshared/code-analyzer.png?label=ready&title=Ready)](https://waffle.io/holyshared/code-analyzer)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/holyshared/code-analyzer/badges/quality-score.png?s=bff77b48e6f3a15bad8f2e8e0153bb5e45e28cae)](https://scrutinizer-ci.com/g/holyshared/code-analyzer/)
[![Coverage Status](https://coveralls.io/repos/holyshared/code-analyzer/badge.png?branch=master)](https://coveralls.io/r/holyshared/code-analyzer?branch=master)

CodeAnalyzer is a library that takes a code coverage.  
This library works with **PHP5.4 or more**.

Requirements
------------------------------------------------
* xdebug >= **2.2.2**

Installation
------------------------------------------------

### Composer setting

CodeAnalyzer can be installed using [Composer](https://getcomposer.org/).  
Please add a description to the **composer.json** in the configuration file.

	{
		"require-dev": {
			"holyshared/code-analyzer": "1.0.2"
		}
	}

### Install CodeAnalyzer

Please execute **composer update** command.

	composer update

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
        	$file->getCodeCoverage()->valueOf(),
        	$file->getExecutedLineCount(),
        	$file->getExecutableLineCount()
		);
		echo $result . "\n";
	}

Other documents
------------------------------------------------

1. [Using the reporter](docs/reporter.md)


How to run the test
------------------------------------------------

### Run only unit test

	vendor/bin/phake test:unit

### Run the code coverage display and unit test

	vendor/bin/phake test:coverage

How to run the example
------------------------------------------------

	vendor/bin/phake example:basic
