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

use Zend\EventManager\EventInterface as BaseEventInterface;

/**
 * Interface StopEventInterface
 * @package cloak
 */
interface StopEventInterface extends BaseEventInterface
{

    public function getResult();

}
