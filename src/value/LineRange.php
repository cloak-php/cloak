<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\value;

/***
 * Class LineRange
 * @package cloak\value
 */
class LineRange
{

    /**
     * @var int
     */
    private $startLineNumber;

    /**
     * @var int
     */
    private $endLineNumber;

    /**
     * @param int $startLineNumber
     * @param int $endLineNumber
     */
    public function __construct($startLineNumber, $endLineNumber)
    {
        $this->startLineNumber = $startLineNumber;
        $this->endLineNumber = $endLineNumber;
    }

    /**
     * @return int
     */
    public function getStartLineNumber()
    {
        return $this->startLineNumber;
    }

    /**
     * @return int
     */
    public function getEndLineNumber()
    {
        return $this->endLineNumber;
    }

}
