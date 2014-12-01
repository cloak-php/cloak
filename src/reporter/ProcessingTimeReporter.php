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

use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;
use cloak\writer\ConsoleWriter;
use Zend\Console\ColorInterface as Color;
use \DateTime;


/**
 * Class ProcessingTimeReporter
 * @package cloak\reporter
 */
class ProcessingTimeReporter implements ReporterInterface
{

    use Reportable;

    /**
     * @var \cloak\writer\ConsoleWriter
     */
    private $console;

    /**
     * @var float
     */
    private $startAt;


    public function __construct()
    {
        $this->console = new ConsoleWriter();
    }

    /**
     * @param \cloak\event\StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
        $sendAt = $event->getSendAt();
        $this->start($sendAt);
    }

    /**
     * @param \cloak\event\StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $this->finish();
    }

    /**
     * @param DateTime $startAt
     */
    private function start(DateTime $startAt)
    {
        $this->console->writeEOL();
        $this->writeStartDateTime($startAt);

        $this->startAt = microtime(true);
    }

    private function finish()
    {
        $endAt = microtime(true);
        $runningTime = round($endAt - $this->startAt, 5);

        $this->console->writeText("Code Coverage Finished in ");
        $this->console->writeText($runningTime, Color::CYAN);
        $this->console->writeText(" seconds");
        $this->console->writeEOL();
    }

    /**
     * @param DateTime $startAt
     */
    private function writeStartDateTime(DateTime $startAt)
    {
        $formatStartTime = $startAt->format('j F Y \a\t H:i');

        $this->console->writeText('Code Coverage Started: ');
        $this->console->writeText($formatStartTime, Color::CYAN);
        $this->console->writeEOL();
    }

}
