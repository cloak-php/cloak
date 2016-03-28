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

use PHPExtra\EventManager\Listener\Listener;
use PHPExtra\EventManager\EventManager;


/**
 * Interface Reporter
 * @package cloak\reporter
 */
interface Reporter extends Listener
{

    /**
     * @param EventManager $eventManager
     */
    public function registerTo(EventManager $eventManager);

}
