<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver;

use cloak\driver\result\FileResult;
use cloak\driver\result\FileNotFoundException;
use cloak\driver\result\collection\FileResultCollection;
use Closure;


/**
 * Class Result
 * @package cloak\driver
 */
class Result
{

    /**
     * @var FileResultCollection
     */
    private $files;


    /**
     * @param \cloak\driver\result\FileResult[] $files
     */
    public function __construct(array $files = [])
    {
        $this->files = new FileResultCollection($files);
    }

    /**
     * @param array $results
     * @return Result
     */
    public static function fromArray(array $results)
    {
        $files = static::parseResult($results);
        return new static($files);
    }

    /**
     * @param array $results
     * @return \cloak\driver\result\FileResult[]
     */
    protected static function parseResult(array $results)
    {
        $files = [];

        foreach ($results as $path => $lineResults) {
            try {
                $file = new FileResult($path, $lineResults);
            } catch (FileNotFoundException $exception) {
                continue;
            }
            $key = $file->getPath();
            $files[$key] = $file;
        }

        return $files;
    }

    /**
     * @param FileResult $file
     */
    public function addFile(FileResult $file)
    {
        $this->files->add($file);
    }

    /**
     * @return FileResultCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function includeFile(Closure $filter)
    {
        $files = $this->files->includeFile($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function includeFiles(array $filters)
    {
        $files = $this->files->includeFiles($filters);
        return $this->createNew($files);
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->files->excludeFile($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function excludeFiles(array $filters)
    {
        $files = $this->files->excludeFiles($filters);
        return $this->createNew($files);
    }

    /**
     * @return int
     */
    public function getFileCount()
    {
        return $this->files->count();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->files->isEmpty();
    }

    /**
     * @param FileResultCollection $collection
     * @return Result
     */
    private function createNew(FileResultCollection $collection)
    {
        $files = $collection->toArray();
        return new self($files);
    }

}
