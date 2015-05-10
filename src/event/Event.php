<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\event;

use PHPExtra\EventManager\Event\EventInterface as BaseEventInterface;


/**
 * Interface Event
 * @package cloak\event
 */
interface Event extends BaseEventInterface
{

    /**
     * @return \DateTimeImmutable
     */
    public function getSendAt();

}
