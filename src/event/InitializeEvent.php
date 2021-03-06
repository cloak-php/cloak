<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\event;

use cloak\AnalyzerConfiguration;
use cloak\value\CoverageBounds;
use cloak\value\Path;

use \DateTimeImmutable;


/**
 * Class InitializeEvent
 * @package cloak\event
 */
final class InitializeEvent implements Event
{

    use DateTimeMessage;

    /**
     * @var AnalyzerConfiguration
     */
    private $config;


    /**
     * @param AnalyzerConfiguration $config
     */
    public function __construct(AnalyzerConfiguration $config)
    {
        $this->sendAt = new DateTimeImmutable();
        $this->config = $config;
    }

    /**
     * @return CoverageBounds
     */
    public function getCoverageBounds()
    {
        return $this->config->getCoverageBounds();
    }

    /**
     * @return Path
     */
    public function getReportDirectory()
    {
        $reportDirectory = $this->config->getReportDirectory();
        return Path::fromString($reportDirectory);
    }

}
