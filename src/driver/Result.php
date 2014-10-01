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
use PhpCollection\AbstractSequence;
use PhpCollection\Sequence;
use Countable;
use IteratorAggregate;
use Closure;


/**
 * Class Result
 * @package cloak\driver
 */
class Result implements Countable, IteratorAggregate
{

    /**
     * @var AbstractSequence
     */
    private $files;


    /**
     * @param AbstractSequence $files
     */
    public function __construct(AbstractSequence $files = null)
    {
        if (is_null($files)) {
            $this->files = new Sequence();
        } else {
            $this->files = $files;
        }
    }

    /**
     * @param File $file
     */
    public function add(File $file)
    {
        $this->files->add($file);
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
    public function count()
    {
        return $this->files->count();
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->files->getIterator();
    }

}
