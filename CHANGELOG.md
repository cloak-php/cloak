ChangeLog
======================================

This is a list of changes from 1.3.1.

Version 1.4.0
---------------------------------------------------------------
* Use of **closure** argument **ConfigurationBuilder** has changed

	target methods: inclueFile, inclueFiles, excludeFile, excludeFiles

	```php
	//before
	$builder->inclueFile(function(\cloak\result\File $file) {
    	//do something
	});
	```

	```php
	//after
	$builder->inclueFile(function(\cloak\driver\result\FileResult $file) {
    	//do something
	});
	```

* **cloak\result\LineSet**, **cloak\result\LineSetInterface** to **LineResultCollection**, **LineResultCollectionInterface**
* **cloak\result\Line** to **LineResult**
* **cloak\result\File** to **FileResult**


Version 1.3.2.4
---------------------------------------------------------------
* Add **MarkdownReporter** from **cloak/markdown-reporter:1.0.2**

Version 1.3.2.3
---------------------------------------------------------------
* Add **LcovReporter** from **cloak/lcov-reporter:1.1.4**

Version 1.3.2.2
---------------------------------------------------------------
* Change the output format of **TextReporter**.
* Change the output format of **ProcessingTimeReporter**.
* Add **WriterInterface**

Version 1.3.2.1
---------------------------------------------------------------
* To the public from the protected **selectLines** method of class **LineSet**
* add **ProcessingTimeReporter** reporter

Version 1.3.2
---------------------------------------------------------------
* **cloak\result\Coverage** to **cloak\value\Coverage**
* add **cloak\result\LineSet** class
* add **cloak\value\LineRange** class
* Remove **addLine**, **removeLine**, **setLines** method from **File** class
* The renamed to **getLineResults** the **getLines** method of the **File** class
* The renamed to **value** the **valueOf** method of the **Coverage** class
* add methods to **Result** class
	* getLineCount
	* getDeadLineCount
	* getUnusedLineCount
	* getExecutedLineCount
	* getExecutableLineCount
	* getCodeCoverage
	* isCoverageLessThan
	* isCoverageGreaterEqual
* Remove class and interface
	* Report
	* ReportInterface,
	* ReportFactoryInterface
	* TextReportFactory

Version 1.3.1
---------------------------------------------------------------
* add **ReportFactoryInterface**, **TextReportFactory**
* add **Report** or **ReportInterface**
* **EventInterface** to **StartEventInterface**
