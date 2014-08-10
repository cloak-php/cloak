<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result;

use cloak\value\Coverage;
use cloak\value\LineRange;

/**
 * Class File
 * @package cloak\result
 */
class File implements CoverageResultInterface
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var LineRange
     */
    private $lineRange;

    /**
     * @var LineSet
     */
    private $lineCoverages;

    /**
     * @param $path
     * @param array $lineResults
     */
    public function __construct($path, LineSetInterface $lineCoverages)
    {
        $this->path = $path;
        $this->resolveLineRange($lineCoverages);
    }

    /**
     * @return string
     */
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

    /**
     * @param $value
     * @return bool
     */
    public function matchPath($value)
    {
        $pathPattern = preg_quote($value, '/');
        $result = preg_match("/" . $pathPattern . "/", $this->getPath());

        return ($result === 0) ? false : true;
    }

    /**
     * @return int
     */
    public function getLineCount()
    {
        return $this->lineRange->getEndLineNumber();
    }

    /**
     * @return LineSet
     */
    public function getLines()
    {
        return $this->lineCoverages;
    }

    /**
     * @param File $file
     * @return bool
     */
    public function equals(File $file)
    {
        return $file->getPath() === $this->getPath();
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        return $this->lineCoverages->getDeadLineCount();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        return $this->lineCoverages->getUnusedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        return $this->lineCoverages->getExecutedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutableLineCount()
    {
        return $this->lineCoverages->getExecutableLineCount();
    }

    /**
     * @return Coverage The value of code coverage
     */
    public function getCodeCoverage()
    {
        return $this->lineCoverages->getCodeCoverage();
    }

    /**
     * @return boolean
     */
    public function isCoverageLessThan(Coverage $coverage)
    {
        return $this->lineCoverages->isCoverageLessThan($coverage);
    }

    /**
     * @return boolean
     */
    public function isCoverageGreaterEqual(Coverage $coverage)
    {
        return $this->lineCoverages->isCoverageGreaterEqual($coverage);
    }

    protected function resolveLineRange(LineSetInterface $lineCoverages)
    {
        $content = file_get_contents($this->getPath());
        $totalLineCount = substr_count(trim($content), PHP_EOL);

        unset($content);

        $this->lineRange = new LineRange(1, $totalLineCount);

        $cleanUpResults = $lineCoverages->selectRange($this->lineRange);
        $this->lineCoverages = $cleanUpResults;
    }

}
