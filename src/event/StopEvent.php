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

use cloak\Result;
use \DateTimeImmutable;


/**
 * Class StopEvent
 * @package cloak\event
 */
final class StopEvent implements Event
{

    use DateTimeMessage;

    /**
     * @var \cloak\Result
     */
    private $result;


    /**
     * @param Result $result
     */
    public function __construct(Result $result)
    {
        $this->result = $result;
        $this->sendAt = new DateTimeImmutable();
    }

    /**
     * @return \cloak\Result
     */
    public function getResult()
    {
        return $this->result;
    }

}
