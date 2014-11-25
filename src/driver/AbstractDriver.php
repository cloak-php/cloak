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
     * @return Result
     */
    public function getAnalyzeResult()
    {
        return Result::fromArray($this->analyzeResult);
    }

}