<?php

namespace CodeAnalyzer;

use \PhpCollection\Sequence;

class File
{

    private $path = null;
    private $lines = null;

    public function __construct($path, array $lines)
    {
        $this->path = $path;
        $this->lines = new Sequence($lines);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function addLine(Line $line)
    {
        $line->setFile($this);
        $this->lines->add($line);
    }

    public function removeLine(Line $line)
    {
        $line->setFile(null);
        $indexAt = $this->lines->indexOf($line);

        if ($indexAt === -1) {
            return;
        }

        $this->lines->remove($indexAt);
    }

    public function equals(File $file)
    {
        return $file->getPath() === $this->getPath();
    }

}
