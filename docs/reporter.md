Reporter
=====================================

The following thing can be used for the reporter of code coverage.

TextReporter
-------------------------------------

You specify the **TextReporter** and to reporter to use.  


### Example code

```php
$builder = new ConfigurationBuilder();
$builder->includeFile('/example/src')
	->excludeFile('/spec')
	->reporter(new TextReporter());

$analyzer = new CoverageAnalyzer( $builder->build() );
$analyzer->start();

//To write code that want to take coverage

$analyzer->stop();
```

### Result of the output

	src/Analyzer.php ..................................................... 100.00% (19/19)
	src/Reporter/TextReporter.php ........................................ 100.00% (27/27)
	src/Reporter/Reportable.php ..........................................  85.71% ( 6/ 7)
	src/Configuration.php ................................................  81.25% (13/16)
	src/ConfigurationBuilder.php .........................................  58.33% (14/24)
