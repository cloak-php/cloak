<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\spec\reporter;

use cloak\reporter\ReporterInterface;
use cloak\reporter\Reportable;
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;


/**
 * Class ReporterFixture
 * @package cloak\spec\reporter
 */
class ReporterFixture implements ReporterInterface
{

    use Reportable;

    private $name;
    private $description;
    private $startEvent;
    private $startEventCount;
    private $stopEvent;
    private $stopEventCount;


    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->startEventCount = 0;
        $this->stopEventCount = 0;
    }

    /**
     * @return void
     */
    public function onStart(StartEventInterface $event)
    {
        $this->startEvent = $event;
        $this->startEventCount++;
    }

    /**
     * @return void
     */
    public function onStop(StopEventInterface $event)
    {
        $this->stopEvent = $event;
        $this->stopEventCount++;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStartEvent()
    {
        return $this->startEvent;
    }

    public function getStartEventCount()
    {
        return $this->startEventCount;
    }

    public function getStopEvent()
    {
        return $this->stopEvent;
    }

    public function getStopEventCount()
    {
        return $this->stopEventCount;
    }

}
