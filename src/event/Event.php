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

use DateTime;

/**
 * Class Event
 * @package cloak\event
 */
abstract class Event
{

    /**
     * @var \DateTime
     */
    protected $sendAt;


    /**
     * @return \DateTime
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

}