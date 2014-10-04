<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\collection;

use PhpCollection\Map;

/**
 * Trait PairStackable
 * @package cloak\collection
 */
trait PairStackable
{

    /**
     * @var \PhpCollection\Map
     */
    protected $map;


    public function first()
    {
    }

    public function last()
    {
        $last = $this->map->last();

        if ($last->isEmpty()) {
            return null;
        }
        $keyPair = $last->get();

        return array_pop($keyPair);
    }

    /**
     * @return int
     */
    public function isEmpty()
    {
        return $this->map->isEmpty();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->map->count();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->map->getIterator();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->createArray($this->map);
    }

    /**
     * @param Map $files
     * @return array
     */
    private function createArray(Map $map)
    {
        $keys = $map->keys();
        $values = $map->values();

        return array_combine($keys, $values);
    }

}
