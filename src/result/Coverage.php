<?php

/**
 * This file is part of easy-coverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage\result;


class Coverage
{

    private $value = 0;

    /**
     * @param float $value
     */
    public function __construct($value)
    {
        $this->value = (float) $value;
    }
 
    public function equals(Coverage $value)
    {
        return ($this->valueOf() === $value->valueOf());
    }
 
    public function lessEquals(Coverage $value)
    {
        return $this->valueOf() <= $value->valueOf();
    }
 
    public function lessThan(Coverage $value)
    {
        return $this->valueOf() < $value->valueOf();
    }
 
    public function greaterEqual(Coverage $value)
    {
        return $this->valueOf() >= $value->valueOf();
    }
 
    public function greaterThan(Coverage $value)
    {
        return $this->valueOf() > $value->valueOf();
    }
 
    public function valueOf()
    {
        return (float) $this->value;
    }
 
    public function __toString()
    {
        return (string) $this->value;
    }
 
}
