<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer\Result;

use \PhpCollection\Sequence;

class File
{

    private $path = null;
    private $lineCount = null;
    private $lines = null;

    public function __construct($path, array $lines = array())
    {
        $this->path = $path;
        $this->resolveLineRange();
        $this->resolveLineCoverages($lines);
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $directoryPath
     */
    public function getRelativePath($directoryPath)
    {
        $directory = realpath($directoryPath) . "/";

        return str_replace($directory, "", $this->getPath());
    }

    public function matchPath($value)
    {
        $pathPattern = preg_quote($value, '/');
        $result = preg_match("/" . $pathPattern . "/", $this->getPath());

        return ($result === 0) ? false : true;
    }

    protected function resolveLineRange()
    {
        $content = file_get_contents($this->getPath());
        $lineContents = explode(PHP_EOL, trim($content));
        $lineCount = count($lineContents);

        unset($content, $lineContents);

        $this->lineCount = $lineCount;
    }

    public function getLineCount()
    {
        return $this->lineCount;
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
        $line->link($this);
        $this->lines->add($line);
    }

    public function removeLine(Line $line)
    {
        $line->unlink();
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

    public function getExecutableLineCount()
    {
        return $this->getUnusedLineCount() + $this->getExecutedLineCount();
    }

    public function selectLines(\Closure $filter)
    {
        $lines = $this->lines->filter($filter);
        return $lines;
    }

    /**
     * @return Coverage The value of code coverage
     */
    public function getCodeCoverage()
    {
        $value = (float) $this->getExecutedLineCount() / $this->getExecutableLineCount() * 100;

        return new Coverage($value);
    }

    /**
     * @return boolean
     */
    public function isCoverageLessThan(Coverage $coverage)
    {
        return $this->getCodeCoverage()->lessThan($coverage);
    }

    /**
     * @return boolean
     */
    public function isCoverageGreaterEqual(Coverage $coverage)
    {
        return $this->getCodeCoverage()->greaterEqual($coverage);
    }

    protected function resolveLineCoverages(array $lineResults)
    {

        $results = array(); 

        foreach ($lineResults as $lineNumber => $analyzeResult) {
            if ($lineNumber <= 0 || $lineNumber > $this->getLineCount()) {
                continue;
            }
            $results[] = new Line($lineNumber, $analyzeResult, $this);
        }

        $this->lines = new Sequence($results);
    }

}
