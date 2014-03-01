<?php

namespace CodeAnalyzer;

use CodeAnalyzer\Result\File;
use \PhpCollection\Sequence;

class Result extends Sequence
{

    private $files = null;

    public function __construct(array $result)
    {
        $this->files = new Sequence();
        parent::__construct($result);
    }

    public static function from(array $result)
    {
        $files = static::parseResult($result);

        return new self($files->all());
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
        $files = $this->filter($filter);
        return $files;
    }

    public function excludeFile(\Closure $filter)
    {
        $files = $this->filterNot($filter);
        return $files;
    }

    public function setFiles(Sequence $files)
    {
        $this->files = $files;
        return $this;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function addFile(File $file)
    {
        $this->add($file);
        return $this;
    }

    public function removeFile(File $file)
    {
        $indexAt = $this->indexOf($file);

        if ($indexAt === -1) {
            return $this;
        }
        $this->remove($indexAt);

        return $this;
    }

}
