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
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;
use cloak\value\Coverage;
use cloak\CoverageResultInterface;
use cloak\writer\ConsoleWriter;
use Zend\Console\ColorInterface as Color;
use cloak\CoverageResultVisitorInterface;


/**
 * Class TreeReporter
 * @package cloak\reporter
 */
class TreeReporter implements ReporterInterface, CoverageResultVisitorInterface
{

    use Reportable;

    const DEFAULT_LOW_BOUND = 35.0;
    const DEFAULT_HIGH_BOUND = 70.0;

    /**
     * @var \cloak\writer\ConsoleWriter
     */
    private $console;

    /**
     * @var \cloak\value\Coverage
     */
    private $lowUpperBound;

    /**
     * @var \cloak\value\Coverage
     */
    private $highLowerBound;


    /**
     * @param float $highLowerBound
     * @param float $lowUpperBound
     */
    public function __construct($highLowerBound = self::DEFAULT_HIGH_BOUND, $lowUpperBound = self::DEFAULT_LOW_BOUND)
    {
        $this->console = new ConsoleWriter();
        $this->lowUpperBound = new Coverage($lowUpperBound);
        $this->highLowerBound = new Coverage($highLowerBound);
    }


    /**
     * @param \cloak\event\StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
    }

    /**
     * @param \cloak\event\StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $this->visit($event->getResult());
    }

    /**
     * @param CoverageResultInterface $result
     */
    public function visit(CoverageResultInterface $result)
    {
        $this->console->writeText($result->getName());
        $this->console->writeEOL();

        $childResults = $result->getChildResults();

        foreach ($childResults as $childResult){
            $this->visit($childResult);
        }
    }

}
