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
use cloak\Configuration;
use PHPExtra\EventManager\EventManagerAwareInterface;


/**
 * Interface AnalyzeLifeCycleNotifierInterface
 * @package cloak
 */
interface AnalyzeLifeCycleNotifierInterface extends EventManagerAwareInterface
{

    /**
     * @return void
     */
    public function notifyInit(Configuration $configuration);

    /**
     * @return void
     */
    public function notifyStart();

    /**
     * @param \cloak\Result $result
     * @return void
     */
    public function notifyStop(Result $result);

}
