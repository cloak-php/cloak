<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\AnalyzeStopEvent;
use cloak\AnalyzedCoverageResult;
use cloak\analyzer\result\LineResult;
use cloak\analyzer\AnalyzedResult;
use \DateTimeImmutable;


describe(AnalyzeStopEvent::class, function() {
    beforeEach(function() {
        $this->rootDirectory = __DIR__ . '/fixtures/src/';

        $analyzeResult = AnalyzedResult::fromArray([
            $this->rootDirectory . 'foo.php' => [
                1 => LineResult::EXECUTED
            ]
        ]);
        $this->result = AnalyzedCoverageResult::fromAnalyzeResult($analyzeResult);
        $this->stopEvent = new AnalyzeStopEvent($this->result);
    });
    describe('#getResult', function() {
        it('return result', function() {
            expect($this->stopEvent->getResult())->toEqual($this->result);
        });
    });
    describe('#getSendAt', function() {
        it('should return time send the event', function() {
            expect($this->stopEvent->getSendAt())->toBeAnInstanceOf(DateTimeImmutable::class);
        });
    });
});
