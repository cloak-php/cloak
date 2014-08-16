ChangeLog
======================================

This is a list of changes from 1.3.1.

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
