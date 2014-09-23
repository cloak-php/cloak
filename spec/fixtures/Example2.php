<?php

namespace cloak\example;

class Example2
{

    public function compare($value1, $value2)
    {
        return $value1 === $value2;
    }

    public function equal($value1, $value2)
    {
        return $this->compare($value1, $value2);
    }

}
