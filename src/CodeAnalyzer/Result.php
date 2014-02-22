<?php

namespace CodeAnalyzer;

use \PhpCollection\Sequence;

class Result
{

    private $files = null; 

    public function __construct(array $result)
    {
        $this->files = new Sequence(); 
        $this->parseResult($result);
    }

    public function from(array $result)
    {
        return new self($result);
    }

    public function parseResult(array $result)
    {
        foreach ($result as $path => $lines) {
            $this->files->add(new File($path, $lines));
        }
        return $this;
    }

}
