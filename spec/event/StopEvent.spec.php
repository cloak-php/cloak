<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\StopEvent;
use cloak\Result;
use cloak\result\LineResult;
use cloak\driver\Result as AnalyzeResult;
use \DateTimeImmutable;

describe(StopEvent::class, function() {
    beforeEach(function() {
        $this->rootDirectory = __DIR__ . '/fixtures/src/';

        $analyzeResult = AnalyzeResult::fromArray([
            $this->rootDirectory . 'foo.php' => [
                1 => LineResult::EXECUTED
            ]
        ]);
        $this->result = Result::fromAnalyzeResult($analyzeResult);
        $this->stopEvent = new StopEvent($this->result);
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
