<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\event;

use cloak\AnalyzedCoverageResult;
use \DateTimeImmutable;


/**
 * Class AnalyzeStopEvent
 * @package cloak\event
 */
final class AnalyzeStopEvent implements Event
{

    use DateTimeMessage;

    /**
     * @var \cloak\AnalyzedCoverageResult
     */
    private $result;


    /**
     * @param AnalyzedCoverageResult $result
     */
    public function __construct(AnalyzedCoverageResult $result)
    {
        $this->result = $result;
        $this->sendAt = new DateTimeImmutable();
    }

    /**
     * @return \cloak\AnalyzedCoverageResult
     */
    public function getResult()
    {
        return $this->result;
    }

}
