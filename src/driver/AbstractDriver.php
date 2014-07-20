<?php

/**
 * This file is part of easy-coverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver;

/**
 * Class AbstractDriver
 * @package cloak\driver
 */
abstract class AbstractDriver implements DriverInterface
{

    /**
     * @var boolean
     */
    protected $started = false;

    /**
     * @var array
     */
    protected $analyzeResult = [];

    /**
     * @return boolean
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->analyzeResult;
    }

}
