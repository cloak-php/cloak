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
 * Class AnalyzerDriver
 * @package cloak\driver
 */
final class AnalyzerDriver implements Driver
{

    /**
     * @var AdaptorInterface
     */
    private $adaptor;


    /**
     * @var boolean
     */
    private $started = false;

    /**
     * @var array
     */
    private $analyzeResult = [];


    /**
     * @param Adaptor $adaptor
     */
    public function __construct(Adaptor $adaptor)
    {
        $this->adaptor = $adaptor;
    }


    public function start()
    {
        $this->adaptor->start();
        $this->started = true;
    }

    public function stop()
    {
        $result = $this->adaptor->stop();
        $this->analyzeResult = $result;
        $this->started = false;
    }

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
