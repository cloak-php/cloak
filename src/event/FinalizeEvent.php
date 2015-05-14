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


use \DateTimeImmutable;


/**
 * Class FinalizeEvent
 * @package cloak\event
 */
final class FinalizeEvent implements Event
{

    use DateTimeMessage;

    public function __construct()
    {
        $this->sendAt = new DateTimeImmutable();
    }

}
