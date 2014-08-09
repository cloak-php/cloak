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

use cloak\result\Line;
use \InvalidArgumentException;

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
        $this->validate();
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

    /**
     * @param int $lineNumber
     * @return bool
     */
    public function contains($lineNumber)
    {
        $result =  $this->getStartLineNumber() <= $lineNumber
            && $this->getEndLineNumber() >= $lineNumber;

        return $result;
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validate()
    {
        if ($this->getStartLineNumber() < 1) {
            throw new InvalidArgumentException();
        }

        $result = $this->getStartLineNumber() < $this->getEndLineNumber();

        if ($result === false) {
            throw new InvalidArgumentException();
        }
    }

}
