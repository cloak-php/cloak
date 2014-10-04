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
use cloak\driver\result\collection\FileResultCollection;
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
     * @var FileResultCollection
     */
    private $files;


    /**
     * @param \cloak\driver\result\File[] $files
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
     * @return \cloak\driver\result\File[]
     */
    protected static function parseResult(array $results)
    {
        $files = [];

        foreach ($results as $path => $lineResults) {
            try {
                $file = new File($path, $lineResults);
            } catch (FileNotFoundException $exception) {
                continue;
            }
            $key = $file->getPath();
            $files[$key] = $file;
        }

        return $files;
    }

    /**
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->files->addFile($file);
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
        return new static( $files->toArray() );
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function includeFiles(array $filters)
    {
        $files = $this->files->includeFiles($filters);
        return new static( $files->toArray() );
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->files->excludeFile($filter);
        return new static( $files->toArray() );
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function excludeFiles(array $filters)
    {
        $files = $this->files->excludeFiles($filters);
        return new self( $files->toArray() );
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
