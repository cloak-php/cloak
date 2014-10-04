<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reflection\collection;

use PhpCollection\Sequence;
use PhpCollection\SequenceInterface;
use cloak\reflection\ReflectionInterface;
use cloak\CollectionInterface;
use cloak\result\LineSetInterface;
use cloak\result\collection\NamedResultCollection;
use \Closure;


/**
 * Class ReflectionCollection
 * @package cloak\reflection\collection
 */
class ReflectionCollection implements CollectionInterface
{

    /**
     * @var SequenceInterface
     */
    private $collection;


    /**
     * @param SequenceInterface $collection
     */
    public function __construct(SequenceInterface $collection = null)
    {
        if (is_null($collection) === false) {
            $this->collection = $collection;
        } else {
            $this->collection = new Sequence();
        }
    }

    /**
     * @param ReflectionInterface $reflection
     */
    public function add(ReflectionInterface $reflection)
    {
        $this->collection->add($reflection);
    }

    /**
     * @param callable $filter
     * @return ReflectionCollection
     */
    public function filter(Closure $filter)
    {
        $collection = $this->collection->filter($filter);
        return new self($collection);
    }

    /**
     * @param LineSetInterface $lineResults
     * @return NamedResultCollection
     */
    public function assembleBy(LineSetInterface $lineResults)
    {
        $assembleCallback = function(ReflectionInterface $reflection) use($lineResults) {
            return $reflection->assembleBy($lineResults);
        };
        $results = $this->collection->map($assembleCallback);

        return new NamedResultCollection( $results->all() );
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->collection->isEmpty();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->collection->getIterator();
    }

}
