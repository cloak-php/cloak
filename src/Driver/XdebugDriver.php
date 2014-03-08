<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer\Driver;

class XdebugDriver implements DriverInterface
{

    protected $started = false;
    protected $analyzeResult = null;

    public function start()
    {
        xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
        $this->started = true;
    }

    public function stop()
    {
        $result = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();

        $this->analyzeResult = $result;
        $this->started = false;
    }

    public function isStarted()
    {
        return $this->started;
    }

    public function getResult()
    {
        return $this->analyzeResult;
    }

}
