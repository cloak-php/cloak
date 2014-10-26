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
use Zend\Config\Config;
use \ReflectionClass;
use \ReflectionException;


/**
 * Class ConfigurationLoader
 * @package cloak
 */
class ConfigurationLoader
{

    /**
     * @var \Zend\Config\Config
     */
    private $config;


    /**
     * @param string $configFilePath
     * @return \cloak\Configuration
     */
    public function loadConfigration($configFilePath)
    {
        $configValues = Toml::Parse($configFilePath);
        $this->config = new Config($configValues);

        $defaults = $this->config->get('defaults');
        $reporters = $defaults->get('reporters');

        $reporter = $this->loadReporters($reporters);

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
     * @param \Zend\Config\Config
     */
    private function loadReporters(Config $config)
    {
        $reporters = [];
        $reporterNames = $config->get('uses');
        $reporterConfigs = $config->get('config');

        foreach ($reporterNames as $reporterName) {
            $arguments = $reporterConfigs->get($reporterName, new Config([]));

            $factory = ReporterFactory::fromName($reporterName);
            $reporter = $factory->createWithArguments( $arguments->toArray() );

            $reporters[] = $reporter;
        }

        return new CompositeReporter($reporters);
    }

}
