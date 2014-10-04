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
use cloak\driver\result\File;
use PhpCollection\Map;
use \Closure;


/**
 * Class FileResultCollection
 * @package cloak\driver\result\collection
 */
class FileResultCollection implements CollectionInterface
{

    /**
     * @var Map
     */
    private $files;


    /**
     * @param \cloak\driver\result\File[] $files
     */
    public function __construct(array $files = [])
    {
        $this->files = new Map($files);
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
     * FIXME array!!
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
        return $this->createNew($files);
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

        return $this->createNew($files);
    }

    /**
     * @param callable $filter
     * @return Result
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->files->filterNot($filter);
        return $this->createNew($files);
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

        return $this->createNew($files);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->files->count();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->files->getIterator();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->files->isEmpty();
    }

    public function last()
    {
        $last = $this->files->last();

        if ($last->isEmpty()) {
            return null;
        }
        $keyPair = $last->get();

        return array_pop($keyPair);
    }

    public function toArray()
    {
        $keys = $this->files->keys();
        $values = $this->files->values();

        return array_combine($keys, $values);
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

    /**
     * @param Map $files
     * @return array
     */
    private function createArray(Map $files)
    {
        $keys = $files->keys();
        $values = $files->values();
        $keyAndFiles = array_combine($keys, $values);

        return $keyAndFiles;
    }

}
