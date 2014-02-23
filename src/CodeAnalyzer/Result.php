<?php

namespace CodeAnalyzer;

use \PhpCollection\Sequence;

class Result
{

    private $files = null; 

    public function __construct(Sequence $files)
    {
        $this->files = $files;
    }

    public static function from(array $result)
    {
        $files = static::parseResult($result);

        return new self($files);
    }

    public static function parseResult(array $result)
    {
        $files = new Sequence(); 

        foreach ($result as $path => $lines) {
            $files->add(new File($path, $lines));
        }
        return $files;
    }

    public function includeFile(\Closure $filter)
    {
        $files = $this->files->filter($filter);
        return new self($files);
    }

    public function excludeFile(\Closure $filter)
    {
        $files = $this->files->filterNot($filter);
        return new self($files);
    }

}
