<?php

use cloak\CoverageAnalyzer;
use cloak\configuration\ConfigurationLoader;
use Evenement\EventEmitterInterface;
use Peridot\Configuration;
use Peridot\Console\Command;
use Peridot\Runner\SuiteLoaderInterface;
use expect\peridot\ExpectPlugin;
use Symfony\Component\Yaml\Yaml;
use Peridot\Reporter\Dot\DotReporterPlugin;
use holyshared\peridot\temporary\TemporaryPlugin;



class SuiteLoader implements SuiteLoaderInterface
{

    public function load($path)
    {
        $tests = $this->getTests($path);

        foreach ($tests as $test) {
            include $test;
        }
    }

    public function getTests($path)
    {
        $targetFiles = [];
        $pattern = $this->excludesPattern();
        $files = $this->getFileIterator();

        foreach ($files as $key => $file) {
            $pathName = $file->getPathname();

            if (preg_match("/{$pattern}/", $pathName) === 1) {
                continue;
            }

            if (preg_match("/.+spec\.php$/", $pathName) === 0) {
                continue;
            }

            $targetFiles[] = $file;
        }

        return $targetFiles;
    }


    private function excludesPattern()
    {
        $coverageConfig = Yaml::parse(file_get_contents(__DIR__ . '/coverage.yml'));
        $excludeTargets = $coverageConfig['targets'];

        $quotePatterns = array_map(function($excludeTarget) {
            return preg_quote($excludeTarget, DIRECTORY_SEPARATOR);
        }, $excludeTargets);

        $pattern = '(' . implode('|', $quotePatterns) . ')';

        return $pattern;
    }

    private function getFileIterator()
    {
        $directoryIterator = new RecursiveDirectoryIterator(__DIR__ . '/spec',
            FilesystemIterator::CURRENT_AS_FILEINFO |
            FilesystemIterator::KEY_AS_PATHNAME |
            FilesystemIterator::SKIP_DOTS
        );

        $filterIterator = new RecursiveIteratorIterator(
            $directoryIterator,
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        return $filterIterator;
    }

}


return function(EventEmitterInterface $emitter)
{
    ExpectPlugin::create()->registerTo($emitter);
    TemporaryPlugin::create()->registerTo($emitter);
    (new DotReporterPlugin($emitter));

    $emitter->on('peridot.load', function(Command $command, Configuration $configuration) {
        $command->setLoader(new SuiteLoader());
    });

    $analyzer = null;

    $emitter->on('peridot.start', function() use(&$analyzer) {
        $loader = new ConfigurationLoader();
        $configuration = $loader->loadConfiguration('cloak.toml');

        $analyzer = new CoverageAnalyzer($configuration);
        $analyzer->start();
    });

    $emitter->on('peridot.end', function() use(&$analyzer) {
        $analyzer->stop();
    });

};
