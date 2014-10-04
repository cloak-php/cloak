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

use cloak\result\NamedResultCollectionInterface;
use cloak\result\NamedCoverageResultInterface;
use PhpCollection\Map;
use cloak\collection\PairStackable;


/**
 * Class NamedResultCollection
 * @package cloak\result\collection
 */
class NamedResultCollection implements NamedResultCollectionInterface
{

    use PairStackable;


    /**
     * @param NamedCoverageResultInterface[] $results
     */
    public function __construct(array $results = [])
    {
        $this->collection = new Map($results);
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

}
