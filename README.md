CodeAnalyzer
=============================

[![Build Status](https://travis-ci.org/holyshared/code-analyzer.png?branch=master)](https://travis-ci.org/holyshared/code-analyzer)

CodeAnalyzer is a library that takes a code coverage.  
This library works with **PHP5.4 or more**.

Required modules
------------------------------------------------
* xdebug >= **2.2.2**

How to use
------------------------------------------------

	use CodeAnalyzer\CodeAnalyzer;
	use CodeAnalyzer\Configuration;

	CodeAnalyzer::configure(function(Configuration $configuration) {

		$configuration->collect(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE)
			->includeFile(function(File $file) {
				return $file->match('/src');
		})
		->includeFile(function(File $file) {
			return $file->match('/spec');
		});

	});

	$analyzer = new CodeAnalyzer();
	$analyzer->start();

	//I write code here want to take code coverage

	$analyzer->stop();

How to run the test
------------------------------------------------

	composer install
	./vendor/bin/pho --reporter spec
