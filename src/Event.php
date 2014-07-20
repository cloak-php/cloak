<?php

/**
 * This file is part of easycoverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage;

use Zend\EventManager\Event as BaseEvent;

class Event extends BaseEvent implements EventInterface
{

    const STOP = 'stop';

    public function getResult()
    {
        return $this->getParam('result', null);
    }

}
