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

use cloak\result\CoverageResultCollectionInterface;
use cloak\CoverageResultInterface;
use PhpCollection\Map;
use cloak\collection\PairStackable;


/**
 * Class CoverageResultCollection
 * @package cloak\result\collection
 */
class CoverageResultCollection implements CoverageResultCollectionInterface
{

    use PairStackable;


    /**
     * @param CoverageResultInterface[] $results
     */
    public function __construct(array $results = [])
    {
        $this->collection = new Map($results);
    }

    /**
     * @param \cloak\CoverageResultInterface $result
     */
    public function add(CoverageResultInterface $result)
    {
        $this->collection->set($result->getName(), $result);
    }

    /**
     * @param CoverageResultInterface[] $results
     */
    public function addAll(array $results)
    {
        foreach ($results as $result) {
            $this->add($result);
        }
    }

    /**
     * @param CoverageResultCollectionInterface $results
     * @return CoverageResultCollectionInterface|void
     */
    public function merge(CoverageResultCollectionInterface $results)
    {
        foreach ($results as $result) {
            $this->add($result);
        }
        return $this;
    }

}
