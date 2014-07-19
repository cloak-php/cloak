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

class HHVMDriver extends AbstractDriver
{

    public function __construct()
    {
        if (defined('HHVM_VERSION') === false) {
            throw new DriverNotAvailableException('Can not be used in the current environment');
        }
    }

    public function start()
    {
        fb_enable_code_coverage();
        $this->started = true;
    }

    public function stop()
    {
        $result = fb_get_code_coverage(true);
        fb_disable_code_coverage();

        $this->analyzeResult = $result;
        $this->started = false;
    }

}
