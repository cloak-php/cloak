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
use cloak\configuration\SectionInterface;
use Zend\Config\Config;

/**
 * Class Report
 * @package cloak\configuration\section
 */
final class Report extends AbstractSection implements SectionInterface
{

    /**
     * {@inheritdoc}
     */
    public function applyTo(ConfigurationBuilder $builder)
    {
        $this->applyReportDirectory($builder)
            ->applyCoverageBounds($builder);

        return $builder;
    }

    /**
     * @param ConfigurationBuilder $builder
     * @return $this
     */
    private function applyReportDirectory(ConfigurationBuilder $builder)
    {
        $reportDirectory = $this->getValue('reportDirectory', getcwd());
        $builder->reportDirectory($reportDirectory);

        return $this;
    }

    /**
     * @param ConfigurationBuilder $builder
     * @return $this
     */
    private function applyCoverageBounds(ConfigurationBuilder $builder)
    {
        $default = new Config([
            'critical' => 35.0,
            'satisfactory' => 70.0
        ]);

        $coverageBounds = $this->getValue('coverageBounds', $default);
        $critical = $coverageBounds->get('critical');
        $satisfactory = $coverageBounds->get('satisfactory');

        $builder->coverageBounds($critical, $satisfactory);

        return $this;
    }

}
