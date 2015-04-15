Cloak
=============================

[![Build Status](https://travis-ci.org/cloak-php/cloak.svg?branch=master)](https://travis-ci.org/cloak-php/cloak)
[![Stories in Ready](https://badge.waffle.io/cloak-php/cloak.png?label=ready&title=Ready)](https://waffle.io/cloak-php/cloak)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cloak-php/cloak/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cloak-php/cloak/?branch=master)
[![Coverage Status](https://coveralls.io/repos/cloak-php/cloak/badge.png?branch=master)](https://coveralls.io/r/cloak-php/cloak?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/53fd5938f4df151fd300000d/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53fd5938f4df151fd300000d)


Cloak is a library that takes a code coverage.  
This library works with **PHP5.4 or more**.

Requirements
------------------------------------------------
* xdebug >= **2.2.2**

Installation
------------------------------------------------

1. Install the [composer](https://getcomposer.org/).  
2. Install the cloak.

		composer require cloak/cloak --dev

How to use
------------------------------------------------

### Setup for the report of code coverage

Setup is required to take a code coverage.  
You can use the **ConfigurationBuilder**, and to apply the settings to the analyzer.


```php
<?php

use cloak\Analyzer;
use cloak\configuration\ConfigurationBuilder;
use cloak\driver\result\FileResult;

$builder = new ConfigurationBuilder();
$builder->includeFile('/example/src')
	->excludeFile('/spec');

$analyzer = new Analyzer( $builder->build() );
```

### Take the code coverage

Run the start / stop at the place where want to take the code coverage.  
After you can get the report, you need to run the **getResult** method.

```php
$analyzer->start();

//I write code here want to take code coverage
example\example1();

$analyzer->stop();

$files = $analyzer->getResult()->getFiles();

foreach ($files as $file) {
    $result = sprintf("%s > %6.2f%% (%d/%d)",
        $file->getName(),
        $file->getCodeCoverage()->value(),
        $file->getExecutedLineCount(),
        $file->getExecutableLineCount()
    );
    echo $result . "\n";
}
```

### Support multiple reporter

You can use at the same time more than one reporter.  
Reporter that are supported by default are as follows.  

* TextReporter
* ProcessingTimeReporter
* LcovReporter
* MarkdownReporter
* TreeReporter

Usage is as follows.  

```php
$reporter = new CompositeReporter([
	new TextReporter(),
	new ProcessingTimeReporter()
]);

$builder = new ConfigurationBuilder();
$builder->includeFile('/example/src')
	->excludeFile('/spec')
	->reporter($reporter);

$analyzer = new Analyzer( $builder->build() );
```

#### Result of the output

	Code Coverage Started: 1 July 2014 at 12:00

	100.00% (19/19) src/Analyzer.php
	100.00% (27/27) src/Reporter/TextReporter.php
	 85.71% ( 6/ 7) src/Reporter/Reportable.php
	 81.25% (13/16) src/Configuration.php
	 58.33% (14/24) src/ConfigurationBuilder.php

	Code Coverage: 96.70%
	Code Coverage Finished in 1.44294 seconds


Configuration file
------------------------------------

If you use the [configuration file](https://gist.github.com/holyshared/5eaa313b2df78818dbad), you can code simple.

```php
use cloak\Analyzer;
use cloak\configuration\ConfigurationLoader;

$loader = new ConfigurationLoader();
$configuration = $loader->loadConfiguration('cloak.toml');

$analyzer = new Analyzer($configuration);
$analyzer->start();

$analyzer->stop();
```


Other documents
------------------------------------------------

1. [Using the reporter](docs/reporter.md)


How to run the test
------------------------------------------------

### Run only unit test

	composer test

### Run the code coverage display and unit test

	composer coverage

How to run the example
------------------------------------------------

	composer example
