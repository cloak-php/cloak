<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer\Reporter;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;

interface ReporterInterface extends ListenerAggregateInterface
{

    public function onStop(EventInterface $event);

}
