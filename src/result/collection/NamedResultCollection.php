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


    public function __construct()
    {
        $this->collection = new Map();
    }

    /**
     * @param \cloak\result\NamedCoverageResultInterface $result
     */
    public function add(NamedCoverageResultInterface $result)
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
