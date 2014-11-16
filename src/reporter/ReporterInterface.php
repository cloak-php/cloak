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
use PHPExtra\EventManager\Listener\ListenerInterface;


/**
 * Interface ReporterInterface
 * @package cloak\reporter
 */
interface ReporterInterface extends ListenerInterface
{

    /**
     * @return void
     */
    public function onStart(StartEventInterface $event);

    /**
     * @return void
     */
    public function onStop(StopEventInterface $event);

}
