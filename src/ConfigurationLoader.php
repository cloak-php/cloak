<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use Yosymfony\Toml\Toml;
use cloak\driver\result\FileResult;
use cloak\reporter\ReporterNotFoundException;
use cloak\reporter\CompositeReporter;
use cloak\reporter\ReporterFactory;
use \ReflectionClass;
use \ReflectionException;


/**
 * Class ConfigurationLoader
 * @package cloak
 */
class ConfigurationLoader
{

    /**
     * @param string $configFilePath
     * @return \cloak\Configuration
     */
    public function loadConfigration($configFilePath)
    {
        $configValues = Toml::Parse($configFilePath);

        $defaults = $configValues['defaults'];
        $reporter = $this->loadReporters($defaults['reporters']);

        $builder = new ConfigurationBuilder();
        $builder->reporter($reporter);

        $builder->includeFile(function (FileResult $file) {
            return $file->matchPaths($defaults['includes']);
        })->excludeFile(function (FileResult $file) {
            return $file->matchPaths($defaults['excludes']);
        });

        return $builder->build();
    }


    /**
     * @param array $config
     */
    private function loadReporters(array $config)
    {

        $reporters = [];
        $reporterNames = $config['uses'];
        $reporterConfigs = $config['config'];

        foreach ($reporterNames as $reporterName) {
            $args = $reporterConfigs[$reporterName];
            $reporters[] = $this->loadReporter($reporterName, $args);
        }

        return new CompositeReporter($reporters);
    }

    /**
     * @param string $reporterName
     * @param array $arguments
     * @return \cloak\reporter\ReporterInterface
     */
    private function loadReporter($reporterName, array $arguments = [])
    {
        $reporterClassNameWithNamespace = $this->getReporterFullName($reporterName);

        try {
            $reflection = new ReflectionClass($reporterClassNameWithNamespace);
        } catch (ReflectionException $exception) {
            throw new ReporterNotFoundException($exception);
        }

        $factory = new ReporterFactory($reflection);

        return $factory->createWithArguments($arguments);
    }

    private function getReporterFullName($reporterName)
    {
        $reporterClassName = ucfirst($reporterName) . 'Reporter';
        $reporterClassNameWithNamespace = "cloak\\reporter\\{$reporterClassName}";

        return $reporterClassNameWithNamespace;
    }


    private function getReporterReflection($reporterName)
    {
        $reporterClassNameWithNamespace = $this->getReporterFullName($reporterName);

        try {
            $reflection = new ReflectionClass($reporterClassNameWithNamespace);
        } catch (ReflectionException $exception) {
            throw new ReporterNotFoundException($exception);
        }

        return $reflection;
    }

}
