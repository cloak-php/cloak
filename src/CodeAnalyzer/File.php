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

    public function setLines(Sequence $lines)
    {
        $this->lines = $lines;
        return $this;
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

    public function getDeadLineCount()
    {
        $lines = $this->selectLines(function(Line $line) {
            return $line->isDead();
        });
        return $lines->count();
    }

    public function getUnusedLineCount()
    {
        $lines = $this->selectLines(function(Line $line) {
            return $line->isUnused();
        });
        return $lines->count();
    }

    public function getExecutedLineCount()
    {
        $lines = $this->selectLines(function(Line $line) {
            return $line->isExecuted();
        });
        return $lines->count();
    }

    public function selectLines(\Closure $filter)
    {
        $lines = $this->lines->filter($filter);
        return $lines;
    }

}
