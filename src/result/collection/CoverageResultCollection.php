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

use cloak\value\Coverage;
use cloak\collection\PairStackable;
use cloak\result\Specification;
use cloak\result\CoverageResultNodeCollection;
use cloak\result\CoverageResultNode;
use cloak\result\specification\Critical;
use cloak\result\specification\Satisfactory;
use PhpCollection\Map;


/**
 * Class CoverageResultCollection
 * @package cloak\result\collection
 */
class CoverageResultCollection implements CoverageResultNodeCollection
{

    use PairStackable;


    /**
     * @param \cloak\result\CoverageResultNode[] $results
     */
    public function __construct(array $results = [])
    {
        $this->collection = new Map($results);
    }

    /**
     * @param \cloak\result\CoverageResultNode $result
     */
    public function add(CoverageResultNode $result)
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
     * @param CoverageResultNodeCollection $results
     * @return CoverageResultCollection|void
     */
    public function merge(CoverageResultNodeCollection $results)
    {
        foreach ($results as $result) {
            $this->add($result);
        }
        return $this;
    }

    /**
     * @param CoverageResultNodeCollection $excludeResults
     * @return CoverageResultCollection
     */
    public function exclude(CoverageResultNodeCollection $excludeResults)
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
     * @param Specification $specification
     * @return CoverageResultCollection
     */
    public function select(Specification $specification)
    {
        $arguments = [$specification, 'match'];
        $results = $this->collection->filter($arguments);
        $results = $this->createArray($results);

        return new self($results);
    }

    /**
     * @param Coverage $coverage
     * @return CoverageResultCollection
     */
    public function selectByCoverageLessThan(Coverage $coverage)
    {
        $specification = Critical::createFromCoverage($coverage);
        $result = $this->select($specification)->sortByCodeCoverage();

        return $result;
    }

    /**
     * @param Coverage $coverage
     * @return CoverageResultCollection
     */
    public function selectByCoverageGreaterEqual(Coverage $coverage)
    {
        $specification = Satisfactory::createFromCoverage($coverage);
        $result = $this->select($specification)->sortByCodeCoverage();

        return $result;
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
    private function compareCoverage(CoverageResultNode $resultA, CoverageResultNode $resultB)
    {
        $coverageA = $resultA->getCodeCoverage();
        $coverageB = $resultB->getCodeCoverage();

        if ($coverageA === $coverageB) {
            return 0;
        }

        return ($coverageA < $coverageB) ? -1 : 1;
    }

}
