<?php

namespace Example;

trait ExampleTrait
{
    private $value;

    public function getValue()
    {
        return $this->value;
    }

}


class Example
{

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

}
