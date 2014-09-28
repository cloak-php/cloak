<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result;

use cloak\result\NamedCoverageResultInterface;
use \Countable;
use \IteratorAggregate;

/**
 * Interface CollectionInterface
 * @package cloak\result
 */
interface CollectionInterface extends IteratorAggregate, Countable
{

    /**
     * @param \cloak\result\NamedCoverageResultInterface $result
     */
    public function add(NamedCoverageResultInterface $result);

}
