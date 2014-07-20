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

use Zend\EventManager\EventInterface as BaseEventInterface;

/**
 * Interface EventInterface
 * @package easycoverage
 */
interface EventInterface extends BaseEventInterface
{

    public function getResult();

}
