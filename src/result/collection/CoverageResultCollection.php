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
use Closure;
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
     * @param CoverageResultCollectionInterface $excludeResults
     * @return CoverageResultCollection
     */
    public function exclude(CoverageResultCollectionInterface $excludeResults)
    {
        $results = clone $this->collection;

        foreach ($excludeResults as $excludeResult) {
            $key = $excludeResult->getName();
            $results->remove($key);
        }
        $results = $this->createArray($results);

        return new self($results);
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
        $result = $this->selectByCallback($callback);

        return $result->sortByCodeCoverage();
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
        $result = $this->selectByCallback($callback);

        return $result->sortByCodeCoverage();
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

    /**
     * @return CoverageResultCollection
     */
    private function sortByCodeCoverage()
    {
        $results = clone $this->collection;
        $results = $this->createArray($results);

        uasort($results, [$this, 'compareCoverage']);

        return new self($results);
    }

    /**
     * @param CoverageResultInterface $resultA
     * @param CoverageResultInterface $resultB
     * @return int
     */
    private function compareCoverage(CoverageResultInterface $resultA, CoverageResultInterface $resultB)
    {
        $coverageA = $resultA->getCodeCoverage();
        $coverageB = $resultB->getCodeCoverage();

        if ($coverageA === $coverageB) {
            return 0;
        }

        return ($coverageA < $coverageB) ? -1 : 1;
    }

}
