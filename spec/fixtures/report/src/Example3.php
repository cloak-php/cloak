<?php

namespace cloak\spec\report;

class Example3
{

    private $name;


    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}
