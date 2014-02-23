<?php

namespace CodeAnalyzer;

use \PhpCollection\Sequence;

class Result
{

    private $files = null; 

    public function __construct(array $result)
    {
        $this->files = $this->parseResult($result);
    }

    public function from(array $result)
    {
        return new self($result);
    }

    public function parseResult(array $result)
    {
        $files = new Sequence(); 

        foreach ($result as $path => $lines) {
            $files->add(new File($path, $lines));
        }
        return $files;
    }

    public function includeFile(\Closure $filter)
    {
        $this->files = $this->files->filter($filter);
        return $this;
    }

    public function excludeFile(\Closure $filter)
    {
        $this->files = $this->files->filterNot($filter);
        return $this;
    }

}
