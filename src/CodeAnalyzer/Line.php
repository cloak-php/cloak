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
    }

    public function setFile(File $file = null)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

}
