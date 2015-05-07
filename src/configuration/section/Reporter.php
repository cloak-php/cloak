<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\configuration\section;

use cloak\configuration\ConfigurationBuilder;
use cloak\configuration\AbstractSection;
use cloak\configuration\Section;
use cloak\reporter\CompositeReporter;
use cloak\reporter\ReporterFactory;


/**
 * Class Reporter
 * @package cloak\configuration
 */
final class Reporter extends AbstractSection implements Section
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

        foreach ($this->getValues() as $reporterName => $arguments) {
            $factory = ReporterFactory::fromName($reporterName);
            $reporter = $factory->createWithArguments( $arguments->toArray() );

            $reporters[] = $reporter;
        }

        return new CompositeReporter($reporters);
    }

}
