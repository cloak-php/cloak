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

use cloak\result\ClassResult;
use cloak\result\CollectionInterface;
use PhpCollection\Map;

/**
 * Class ClassResultCollection
 * @package cloak\result\collection
 */
class ClassResultCollection implements CollectionInterface
{

    /**
     * @var \PhpCollection\Map
     */
    private $collection;


    public function __construct()
    {
        $this->collection = new Map();
    }

    /**
     * @param ClassResult $result
     */
    public function add(ClassResult $result)
    {
        $this->collection->set($result->getName(), $result);
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
