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


/**
 * Trait ElementStackable
 * @package cloak\collection
 */
trait ElementStackable
{

    use Stackable;

    public function first()
    {
    }

    public function last()
    {
        $last = $this->collection->last();

        if ($last->isEmpty()) {
            return null;
        }

        return $last->get();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->collection->all();
    }

}
