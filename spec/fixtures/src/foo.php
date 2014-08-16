<?php

namespace Example;

class Example
{

    private $value;

    public function _construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

}
