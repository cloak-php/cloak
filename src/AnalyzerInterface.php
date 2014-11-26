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

/**
 * Interface AnalyzerInterface
 * @package cloak
 */
interface AnalyzerInterface
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
     * @return bool
     */
    public function isStarted();

    /**
     * @return \cloak\Result
     */
    public function getResult();

}
