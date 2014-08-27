Cloak
=============================

[![Build Status](https://travis-ci.org/cloak-php/cloak.svg?branch=master)](https://travis-ci.org/cloak-php/cloak)
[![Stories in Ready](https://badge.waffle.io/cloak-php/cloak.png?label=ready&title=Ready)](https://waffle.io/cloak-php/cloak)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cloak-php/cloak/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cloak-php/cloak/?branch=master)
[![Coverage Status](https://coveralls.io/repos/cloak-php/cloak/badge.png)](https://coveralls.io/r/cloak-php/cloak)

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
			"cloak/cloak": "1.3.2.1"
		}
	}

### Install Cloak

Please execute **composer install** command.

	composer install

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
        	$file->getCodeCoverage()->value(),
        	$file->getExecutedLineCount(),
        	$file->getExecutableLineCount()
		);
		echo $result . "\n";
	}


### Reporter complex

You can use at the same time more than one reporter.  
Reporter that are supported by default are as follows.  

* TextReporter
* ProcessingTimeReporter

Usage is as follows.  

	$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

	    $builder->reporter(new CompositeReporter([
    	    new TextReporter(),
        	new ProcessingTimeReporter()
	    ]));

	    $builder->includeFile(function(File $file) {
    	    return $file->matchPath('/example/src');
    	})->excludeFile(function(File $file) {
        	return $file->matchPath('/spec');
	    });

	});


#### Result of the output

	Start at: 1 July 2014 at 12:00

	Total code coverage: 96.36%

	src/Analyzer.php ..................................................... 100.00% (19/19)
	src/Reporter/TextReporter.php ........................................ 100.00% (27/27)
	src/Reporter/Reportable.php ..........................................  85.71% ( 6/ 7)
	src/Configuration.php ................................................  81.25% (13/16)
	src/ConfigurationBuilder.php .........................................  58.33% (14/24)

	Finished in 0.27125 seconds

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
