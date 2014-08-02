<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;

use cloak\Result;
use cloak\result\Coverage;
use cloak\event\StopEventInterface;
use cloak\report\factory\TextReportFactory;

/**
 * Class TextReporter
 * @package cloak\reporter
 */
class TextReporter implements ReporterInterface
{

    use Reportable;

    const DEFAULT_LOW_BOUND = 35.0;
    const DEFAULT_HIGH_BOUND = 70.0;

    /**
     * @var \cloak\report\factory\TextReportFactory
     */
    private $factory;

    /**
     * @param float $highLowerBound
     * @param float $lowUpperBound
     */
    public function __construct($highLowerBound = self::DEFAULT_LOW_BOUND, $lowUpperBound = self::DEFAULT_HIGH_BOUND)
    {
        $this->factory = new TextReportFactory(
            new Coverage($lowUpperBound),
            new Coverage($highLowerBound)
        );
    }

    /**
     * @param \cloak\event\StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $result = $event->getResult();
        $report = $this->factory->createFromResult($result);
        $report->output();
    }

}
