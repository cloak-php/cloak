<?php

namespace CodeAnalyzer;

class File
{

    private $path = null;
    private $lines = null;

    public function __construct($path, array $lines)
    {
        $this->path = $path;
        $this->lines = $lines;
    }

    public function getPath()
    {
        return $this->path;
    }

}
