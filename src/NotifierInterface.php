<?php

/**
 * This file is part of easy-coverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage;

use easycoverage\Result;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Interface NotifierInterface
 * @package easycoverage
 */
interface NotifierInterface extends EventManagerAwareInterface
{

    /**
     * @param \easycoverage\Result $result
     * @return void
     */
    public function stop(Result $result);

}
