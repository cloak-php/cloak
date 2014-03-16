<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer;

use CodeAnalyzer\Result,
    Zend\EventManager\EventManagerAwareInterface;

interface NotifierInterface extends EventManagerAwareInterface
{

    /**
     * @param \CodeAnalyzer\Result $result
     * @return void
     */
    public function stop(Result $result);

}
