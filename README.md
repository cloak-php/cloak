Cloak
=============================

[![Build Status](https://travis-ci.org/holyshared/cloak.svg?branch=master)](https://travis-ci.org/holyshared/cloak)
[![Stories in Ready](https://badge.waffle.io/holyshared/cloak.png?label=ready&title=Ready)](https://waffle.io/holyshared/cloak)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/holyshared/cloak/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/holyshared/cloak/?branch=master)
[![Coverage Status](https://coveralls.io/repos/holyshared/cloak/badge.png)](https://coveralls.io/r/holyshared/cloak)
[![Dependencies Status](https://depending.in/holyshared/cloak.png)](http://depending.in/holyshared/cloak)


Cloak is a library that takes a code coverage.  
This library works with **PHP5.4 or more**.

Requirements
------------------------------------------------
* xdebug >= **2.2.2**

Installation
------------------------------------------------

### Composer setting

Cloak can be installed using [Composer](https://getcomposer.org/).  
Please add a description to the **composer.json** in the configuration file.

	{
		"require-dev": {
			"cloak/cloak": "1.2.0"
		}
	}

### Install Cloak

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

	use cloak\Analyzer;
	use cloak\ConfigurationBuilder;
	use cloak\Result\File;

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
