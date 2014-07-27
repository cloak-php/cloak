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

/**
 * Class StopEvent
 * @package cloak\event
 */
class StopEvent extends Event implements StopEventInterface
{

    protected $name = 'stop';

    /**
     * @return \cloak\Result
     */
    public function getResult()
    {
        return $this->getParam('result', null);
    }

}
