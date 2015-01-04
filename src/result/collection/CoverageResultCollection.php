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
use cloak\result\CoverageResultInterface;
use Mockery\Matcher\Closure;
use PhpCollection\Map;
use cloak\collection\PairStackable;
use cloak\value\Coverage;


/**
 * Class CoverageResultCollection
 * @package cloak\result\collection
 */
class CoverageResultCollection implements CoverageResultCollectionInterface
{

    use PairStackable;


    /**
     * @param \cloak\result\CoverageResultInterface[] $results
     */
    public function __construct(array $results = [])
    {
        $this->collection = new Map($results);
    }

    /**
     * @param \cloak\result\CoverageResultInterface $result
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

    /**
     * @param Coverage $coverage
     * @return CoverageResultCollection
     */
    public function selectByCoverageLessThan(Coverage $coverage)
    {
        $callback = function(CoverageResultInterface $result) use ($coverage) {
            return $result->isCoverageLessThan($coverage);
        };

        return $this->selectByCallback($callback);
    }

    /**
     * @param Coverage $coverage
     * @return CoverageResultCollection
     */
    public function selectByCoverageGreaterEqual(Coverage $coverage)
    {
        $callback = function(CoverageResultInterface $result) use ($coverage) {
            return $result->isCoverageGreaterEqual($coverage);
        };

        return $this->selectByCallback($callback);
    }

    /**
     * @param Closure $callback
     * @return CoverageResultCollection
     */
    private function selectByCallback(Closure $callback)
    {
        $results = $this->collection->filter($callback);
        $results = $this->createArray($results);

        return new self($results);
    }

}
