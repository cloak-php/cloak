<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver;

/**
 * Interface Driver
 * @package cloak\driver
 */
interface Driver
{

    /**
     * @return void
     */
    public function start();

    /**
     * @return void
     */
    public function stop();

    /**
     * @return boolean
     */
    public function isStarted();

    /**
     * @return Result
     */
    public function getAnalyzeResult();

}
