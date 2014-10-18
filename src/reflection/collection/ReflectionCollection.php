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
use PhpCollection\Map;
use cloak\collection\PairStackable;
use cloak\reflection\ReflectionInterface;
use cloak\CollectionInterface;
use cloak\result\LineResultCollectionInterface;
use cloak\result\collection\CoverageResultCollection;
use \Closure;
use \Iterator;
use \ArrayIterator;


/**
 * Class ReflectionCollection
 * @package cloak\reflection\collection
 */
class ReflectionCollection implements CollectionInterface
{

    use PairStackable;


    /**
     * @param ReflectionInterface[] $reflections
     */
    public function __construct(array $reflections = [])
    {
        $this->collection = new Map();
        $this->addAll($reflections);
    }

    /**
     * @param ReflectionInterface $reflection
     */
    public function add(ReflectionInterface $reflection)
    {
        $identityName = $reflection->getIdentityName();
        $this->collection->set($identityName, $reflection);
    }

    /**
     * @param ReflectionInterface[] $reflections
     */
    public function addAll(array $reflections)
    {
        $this->pushAll(new ArrayIterator($reflections));
    }

    /**
     * @param ReflectionCollection $collection
     */
    public function merge(ReflectionCollection $reflections)
    {
        $this->pushAll( $reflections->getIterator() );
    }

    /**
     * @param Iterator $reflections
     */
    private function pushAll(Iterator $reflections)
    {
        foreach ($reflections as $reflection) {
            $this->add($reflection);
        }
    }

    /**
     * @param callable $filter
     * @return ReflectionCollection
     */
    public function filter(Closure $filter)
    {
        $collection = $this->collection->filter($filter);
        return new self( $collection->values() );
    }

    /**
     * @param LineResultCollectionInterface $lineResults
     * @return CoverageResultCollection
     */
    public function assembleBy(LineResultCollectionInterface $lineResults)
    {
        $values = $this->collection->values();
        $collection = new Sequence($values);

        $assembleCallback = function(ReflectionInterface $reflection) use($lineResults) {
            return $reflection->assembleBy($lineResults);
        };
        $results = $collection->map($assembleCallback);

        return new CoverageResultCollection( $results->all() );
    }

}
