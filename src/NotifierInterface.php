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

use cloak\Result;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Interface NotifierInterface
 * @package cloak
 */
interface NotifierInterface extends EventManagerAwareInterface
{

    /**
     * @param \cloak\Result $result
     * @return void
     */
    public function stop(Result $result);

}
