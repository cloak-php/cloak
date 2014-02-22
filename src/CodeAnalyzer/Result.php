<?php

namespace CodeAnalyzer;

class Result
{

    private $files = array(); 

    public function __construct(array $result)
    {
        $this->parseResult($result);
    }

    public function from(array $result)
    {
        return new self($result);
    }

    public function parseResult(array $result)
    {
        foreach ($result as $path => $lines) {
            $this->files[] = new File($path, $lines);
        }
    }

}
