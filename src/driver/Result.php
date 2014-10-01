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

use cloak\driver\result\File;
use cloak\driver\result\FileNotFoundException;
use PhpCollection\AbstractMap;
use PhpCollection\Map;
use PhpCollection\Sequence;
use Closure;


/**
 * Class Result
 * @package cloak\driver
 */
class Result
{

    /**
     * @var AbstractMap
     */
    private $files;


    /**
     * @param AbstractMap $files
     */
    public function __construct(AbstractMap $files = null)
    {
        if (is_null($files)) {
            $this->files = new Map();
        } else {
            $this->files = $files;
        }
    }

    /**
     * @param array $results
     * @return static
     */
    public static function fromArray(array $results)
    {
        $files = static::parseResult($results);
        return new static($files);
    }

    /**
     * @param array $results
     * @return Map
     */
    protected static function parseResult(array $results)
    {
        $files = new Map();

        foreach ($results as $path => $lineResults) {
            try {
                $file = new File($path, $lineResults);
            } catch (FileNotFoundException $exception) {
                continue;
            }
            $files->set($file->getPath(), $file);
        }

        return $files;
    }

    /**
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->files->set($file->getPath(), $file);
    }

    /**
     * @return Sequence
     */
    public function getFiles()
    {
        $files = new Sequence($this->files->values());
        return $files;
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function includeFile(Closure $filter)
    {
        $files = $this->files->filter($filter);
        return new self($files);
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function includeFiles(array $filters)
    {
        $files = $this->files;

        foreach ($filters as $filter) {
            $files = $files->filter($filter);
        }

        return new self($files);
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->files->filterNot($filter);
        return new self($files);
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function excludeFiles(array $filters)
    {
        $files = $this->files;

        foreach ($filters as $filter) {
            $files = $files->filterNot($filter);
        }

        return new self($files);
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

}
