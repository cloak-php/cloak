<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use IteratorAggregate;
use Countable;


/**
 * Interface Collection
 * @package cloak
 */
interface Collection extends Countable, IteratorAggregate
{

    /**
     * @return mixed
     */
    public function first();

    /**
     * @return mixed
     */
    public function last();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return mixed
     */
    public function toArray();

}
