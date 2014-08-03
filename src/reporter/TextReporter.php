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
use cloak\report\factory\ReportFactoryInterface;
use cloak\report\factory\TextReportFactory;

/**
 * Class TextReporter
 * @package cloak\reporter
 */
class TextReporter implements ReporterInterface
{

    use Reportable;

    const PAD_CHARACTER_LENGTH = 70;

    /**
     * @var \cloak\report\factory\TextReportFactory
     */
    private $factory;

    /**
     * @param ReportFactoryInterface $factory
     */
    public function __construct(ReportFactoryInterface $factory = null)
    {
        $this->factory = $factory ?: new TextReportFactory();
    }

    /**
     * @param \cloak\event\StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
        $startAt = $event->getSendAt()->format('j F Y \a\t H:i');
        echo str_pad("", static::PAD_CHARACTER_LENGTH, "-"), PHP_EOL;
        echo "Start at: ", $startAt, PHP_EOL;
        echo str_pad("", static::PAD_CHARACTER_LENGTH, "-"), PHP_EOL;
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
