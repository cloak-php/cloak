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

use cloak\event\AnalyzeStartEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\writer\ConsoleWriter;
use Zend\Console\ColorInterface as Color;
use \DateTimeImmutable;


/**
 * Class ProcessingTimeReporter
 * @package cloak\reporter
 */
class ProcessingTimeReporter
    implements Reporter, AnalyzeStartEventListener, AnalyzeStopEventListener
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
     * @param \cloak\event\AnalyzeStartEvent $event
     */
    public function onAnalyzeStart(AnalyzeStartEvent $event)
    {
        $sendAt = $event->getSendAt();
        $this->start($sendAt);
    }

    /**
     * @param \cloak\event\AnalyzeStopEvent $event
     */
    public function onAnalyzeStop(AnalyzeStopEvent $event)
    {
        $this->finish();
    }

    /**
     * @param DateTimeImmutable $startAt
     */
    private function start(DateTimeImmutable $startAt)
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
     * @param DateTimeImmutable $startAt
     */
    private function writeStartDateTime(DateTimeImmutable $startAt)
    {
        $formatStartTime = $startAt->format('j F Y \a\t H:i');

        $this->console->writeText('Code Coverage Started: ');
        $this->console->writeText($formatStartTime, Color::CYAN);
        $this->console->writeEOL();
    }

}
