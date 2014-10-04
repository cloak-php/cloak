<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result\collection;

use cloak\result\CollectionInterface;
use cloak\result\NamedCoverageResultInterface;
use PhpCollection\Map;
use \Iterator;

/**
 * Class NamedResultCollection
 * @package cloak\result\collection
 */
class NamedResultCollection implements CollectionInterface
{

    /**
     * @var \PhpCollection\Map
     */
    private $collection;


    /**
     * @param NamedCoverageResultInterface[] $results
     */
    public function __construct(array $results = [])
    {
        $this->collection = new Map();
        $this->addAll($results);
    }

    /**
     * @param \cloak\result\NamedCoverageResultInterface $result
     */
    public function add(NamedCoverageResultInterface $result)
    {
        $this->collection->set($result->getName(), $result);
    }

    /**
     * @param NamedCoverageResultInterface[] $results
     */
    public function addAll(array $results)
    {
        foreach ($results as $result) {
            $this->add($result);
        }
    }

    /**
     * @return int
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
