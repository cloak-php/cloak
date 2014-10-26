<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\configuration;

use cloak\ConfigurationBuilder;
use cloak\reporter\CompositeReporter;
use cloak\reporter\ReporterFactory;
use Zend\Config\Config;


/**
 * Class Reporter
 * @package cloak\configuration
 */
class Reporter extends AbstractNode implements NodeInterface
{

    /**
     * {@inheritdoc}
     */
    public function applyTo(ConfigurationBuilder $builder)
    {
        return $builder->reporter($this->loadReporters());
    }

    /**
     * @return CompositeReporter
     */
    private function loadReporters()
    {
        $reporters = [];
        $reporterNames = $this->values->get('uses');
        $reporterConfigs = $this->values->get('configs');

        foreach ($reporterNames as $reporterName) {
            $arguments = $reporterConfigs->get($reporterName, new Config([]));

            $factory = ReporterFactory::fromName($reporterName);
            $reporter = $factory->createWithArguments( $arguments->toArray() );

            $reporters[] = $reporter;
        }

        return new CompositeReporter($reporters);
    }

}
