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

use cloak\AnalyzedCoverageResult;
use cloak\Configuration;


/**
 * Interface LifeCycleNotifier
 * @package cloak
 */
interface LifeCycleNotifier
{

    /**
     * @return void
     */
    public function notifyInitialize(Configuration $configuration);

    /**
     * @return void
     */
    public function notifyStart();

    /**
     * @param \cloak\AnalyzedCoverageResult $result
     * @return void
     */
    public function notifyStop(AnalyzedCoverageResult $result);

}
