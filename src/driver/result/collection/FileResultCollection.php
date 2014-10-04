<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver\result\collection;

use cloak\CollectionInterface;
use cloak\collection\PairStackable;
use cloak\driver\result\File;
use PhpCollection\Map;
use \Closure;


/**
 * Class FileResultCollection
 * @package cloak\driver\result\collection
 */
class FileResultCollection implements CollectionInterface
{

    use PairStackable;


    /**
     * @param \cloak\driver\result\File[] $files
     */
    public function __construct(array $files = [])
    {
        $this->collection = new Map($files);
    }

    /**
     * @param File $file
     */
    public function add(File $file)
    {
        $this->collection->set($file->getPath(), $file);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->toArray();
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function includeFile(Closure $filter)
    {
        $files = $this->collection->filter($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function includeFiles(array $filters)
    {
        $result = $this;

        foreach ($filters as $filter) {
            $result = $result->includeFile($filter);
        }

        return $result;
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->collection->filterNot($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return Result
     */
    public function excludeFiles(array $filters)
    {
        $result = $this;

        foreach ($filters as $filter) {
            $result = $result->excludeFile($filter);
        }

        return $result;
    }

    /**
     * @param Map $files
     * @return FileResultCollection
     */
    private function createNew(Map $files)
    {
        $values = $this->createArray($files);
        return new self($values);
    }

}
