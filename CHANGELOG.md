ChangeLog
======================================

This is a list of changes from 1.3.1.

Version 1.8.1
---------------------------------------------------------------
* peridot-expectation to peridot-expect-plugin

Version 1.8.0
---------------------------------------------------------------
* Driver detector bugfix

Version 1.7.0
---------------------------------------------------------------
* Upgrade yosymfony/toml (v3.0)

Version 1.6.0
---------------------------------------------------------------
* Remove **ReflectionInterface::assembleBy** method
* Add **cloak\reflection\LineResultSelectable** interface
* Add **cloak\reflection\collectionResultCollectionConvertible** interface
* Changed reporter colors
	* before
		* critical - yellow
		* warning - normal(white)
		* satisfactory - green
	* after
		* critical - red
		* warning - yellow
		* satisfactory - green

Version 1.5.0
---------------------------------------------------------------
* Remove **Analyzer::factory** method
* Support **init event** for reporter
* Changed the format of the configuration file.
	* Added the report section
		```toml
		[report]
		reportDirectory = "./tmp"

		[report.coverageBounds]
		satisfactory = 70.0
		critical = 35.0
		```
	* Removed the option of text reporter and tree reporter.
		* Removed **critical** option
		* Removed **satisfactory** option
	* Changed the **outputFilePath** of **lcov reporter** and **markdown reporter** to **fileName**.

### Other documents

* [Cloak-1.5.0 configuration file format](https://gist.github.com/holyshared/5eaa313b2df78818dbad)
* [Cloak-1.4.x configuration file format](https://gist.github.com/holyshared/06b726254ce4a2fec899)


Version 1.4.4
---------------------------------------------------------------
* Changed **MarkdownReporter** of format
* Add **satisfactory**, **critical** on the setting of the **MarkdownReporter**
* Bug fixes coverage of calculation logic
* Fixed output result of **TreeReporter**
* Changed parameter name of **TreeReporter** and **TextReporter**
	* before
	```toml
	highLowerBound = 70.0
	lowUpperBound = 35.0
	```
	* after
	```toml
	satisfactory = 70.0
	critical = 35.0
	```

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
* **cloak\ConfigrationBuilder** to **cloak\configration\ConfigrationBuilder**
* **cloak/DriverDetector** to **cloak/driver/DriverDetector**
* **cloak/DriverDetectorInterface** to **cloak/driver/DriverDetectorInterface**
* **cloak/DriverNotFoundException** to **cloak/driver/DriverNotFoundException**
* Support configuration file (toml format)
* Support class, trait, method code coverage


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
