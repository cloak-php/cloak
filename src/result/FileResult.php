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

use cloak\value\LineRange;
use cloak\reflection\FileReflection;


/**
 * Class FileResult
 * @package cloak\result
 */
class FileResult implements NamedCoverageResultInterface
{

    use CoverageResult;


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
        return $this->lineResults;
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
     * @param LineResultCollectionInterface $lineCoverages
     */
    protected function resolveLineRange(LineResultCollectionInterface $lineCoverages)
    {
        $fileReflection = new FileReflection($this->getPath());
        $this->lineRange = $fileReflection->getLineRange();

        $this->factory = new ResultFactory($fileReflection);

        $cleanUpResults = $lineCoverages->selectRange($this->lineRange);
        $this->lineResults = $cleanUpResults;
    }

    /**
     * @return \cloak\result\collection\NamedResultCollection
     */
    public function getClassResults()
    {
        return $this->factory->createClassResults($this->lineResults);
    }

    /**
     * @return \cloak\result\collection\NamedResultCollection
     */
    public function getTraitResults()
    {
        return $this->factory->createTraitResults($this->lineResults);
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
