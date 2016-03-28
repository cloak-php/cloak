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

use cloak\reporter\Reporter;
use PHPExtra\EventManager\EventManager;


/**
 * Class ReporterFixture
 * @package cloak\spec\reporter
 */
class ReporterFixture implements Reporter
{

    private $name;
    private $description;

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
     * @param EventManager $eventManager
     */
    public function registerTo(EventManager $eventManager)
    {
        $eventManager->add($this);
    }

}
