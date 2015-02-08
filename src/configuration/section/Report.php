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
        $reportDirectory = $this->values->get('reportDirectory', getcwd());
        $coverageBounds = $this->values->get('coverageBounds', [
            'critical' => 35.0,
            'satisfactory' => 70.0
        ]);

        $builder->reportDirectory($reportDirectory)
            ->coverageBounds($coverageBounds['critical'], $coverageBounds['satisfactory']);

        return $builder;
    }

}
