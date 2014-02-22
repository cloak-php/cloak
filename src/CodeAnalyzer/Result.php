<?php

namespace CodeAnalyzer;

class Result
{

    private $result = array(); 

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function from(array $result)
    {
        return new self($result);
    }

}
