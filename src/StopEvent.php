<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use Zend\EventManager\Event as BaseEvent;

/**
 * Class StopEvent
 * @package cloak
 */
class StopEvent extends BaseEvent implements StopEventInterface
{

    const NAME = 'stop';

    /**
     * @param  string|object $target
     * @param  array|\ArrayAccess $params
     */
    public function __construct($target = null, $params = null)
    {
        parent::__construct(static::NAME, $target, $params);
    }

    /**
     * @return \cloak\Result
     */
    public function getResult()
    {
        return $this->getParam('result', null);
    }

}
