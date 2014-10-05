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
use cloak\reflection\FileReflection;


/**
 * Class FileResult
 * @package cloak\result
 */
class FileResult implements NamedCoverageResultInterface
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var \cloak\result\ResultFactory
     */
    private $factory;

    /**
     * @var LineRange
     */
    private $lineRange;

    /**
     * @var \cloak\result\LineResultCollectionInterface
     */
    private $lineCoverages;


    /**
     * @param $path
     * @param \cloak\result\LineResultCollectionInterface $lineResults
     */
    public function __construct($path, LineResultCollectionInterface $lineCoverages)
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
     * @return string
     */
    public function getName()
    {
        return $this->getPath();
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
     * @return \cloak\result\LineResultCollectionInterface
     */
    public function getLineResults()
    {
        return $this->lineCoverages;
    }

    /**
     * @param FileResult $file
     * @return bool
     */
    public function equals(FileResult $file)
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

    /**
     * @param LineResultCollectionInterface $lineCoverages
     */
    protected function resolveLineRange(LineResultCollectionInterface $lineCoverages)
    {
        $fileReflection = new FileReflection($this->getPath());
        $this->lineRange = $fileReflection->getLineRange();

        $this->factory = new ResultFactory($fileReflection);

        $cleanUpResults = $lineCoverages->selectRange($this->lineRange);
        $this->lineCoverages = $cleanUpResults;
    }

    /**
     * @return \cloak\result\collection\NamedResultCollection
     */
    public function getClassResults()
    {
        return $this->factory->createClassResults($this->lineCoverages);
    }

    /**
     * @return \cloak\result\collection\NamedResultCollection
     */
    public function getTraitResults()
    {
        return $this->factory->createTraitResults($this->lineCoverages);
    }

    /**
     * @return bool
     */
    public function hasChildResults()
    {
        return $this->getChildResults()->isEmpty() === false;
    }

    /**
     * @return NamedResultCollectionInterface
     */
    public function getChildResults()
    {
        $results = $this->getClassResults();
        return $results->merge($this->getTraitResults());
    }

}
