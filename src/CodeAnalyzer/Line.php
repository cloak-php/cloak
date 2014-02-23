<?php

namespace CodeAnalyzer;

class Line
{

    const EXECUTED = 1; 
    const UNUSED = -1; 
    const DEAD = -2;

    private $file = null;
    private $lineNumber = null;
    private $analyzeResult = null;

    public function __construct($lineNumber, $analyzeResult = self::EXECUTED, File $file = null)
    {
        $this->lineNumber = $lineNumber;
        $this->analyzeResult = $analyzeResult;
        $this->file = $file;
    }

    public function setFile(File $file = null)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    public function getAnalyzeResult()
    {
        return $this->analyzeResult;
    }

    public function isDead()
    {
        return $this->analyzeResult === self::DEAD;
    }

    public function isUnused()
    {
        return $this->analyzeResult === self::UNUSED;
    }

    public function isExecuted()
    {
        return $this->analyzeResult === self::EXECUTED;
    }

    public function equals(Line $line)
    {
        return ($line->getLineNumber() === $line->getLineNumber() && $line->getFile() === $line->getFile());
    }

}
