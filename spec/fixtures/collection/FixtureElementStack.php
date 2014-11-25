<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\spec\collection;

use cloak\collection\ElementStackable;
use PhpCollection\Sequence;

/**
 * Class FixtureElementStack
 * @package cloak\spec\collection
 */
class FixtureElementStack
{

    use ElementStackable;

    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->collection = new Sequence($values);
    }

}
