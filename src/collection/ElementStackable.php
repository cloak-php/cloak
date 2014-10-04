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

use PhpOption\Option;


/**
 * Trait ElementStackable
 * @package cloak\collection
 */
trait ElementStackable
{

    use Stackable;

    public function first()
    {
        $first = $this->collection->first();
        return $first->getOrElse(null);
    }

    public function last()
    {
        $last = $this->collection->last();
        return $last->getOrElse(null);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->collection->all();
    }

}
