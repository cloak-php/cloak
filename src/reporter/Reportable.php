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

use PHPExtra\EventManager\EventManagerInterface;

/**
 * Trait Reportable
 * @package cloak\reporter
 */
trait Reportable
{

    /**
     * @param EventManagerInterface $eventManager
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $eventManager->addListener($this);
    }

}
