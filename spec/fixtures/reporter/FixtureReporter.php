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
 * Class FixtureReporter
 * @package cloak\spec\reporter
 */
class FixtureReporter implements ReporterInterface
{

    use Reportable;

    private $name;
    private $description;


    /**
     * @param $name
     * @param $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return void
     */
    public function onStart(StartEventInterface $event)
    {
    }

    /**
     * @return void
     */
    public function onStop(StopEventInterface $event)
    {
    }

}
