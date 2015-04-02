<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Result;
use cloak\Configuration;
use cloak\result\LineResult;
use cloak\event\InitEvent;
use cloak\event\StopEvent;
use cloak\reporter\LcovReporter;
use cloak\driver\Result as AnalyzeResult;
use \DateTime;


describe('LcovReporter', function() {
    describe('onStop', function() {
        beforeEach(function() {
            $this->reportDirectory = __DIR__ . '/../tmp';
            $this->reportFileName = 'report.lcov';
            $this->reportFile = __DIR__ . '/../tmp/report.lcov';
            $this->reporter = new LcovReporter($this->reportFileName);

            $this->source1 = realpath(__DIR__ . '/../fixtures/Example1.php');
            $this->source2 = realpath(__DIR__ . '/../fixtures/Example2.php');

            $analyzeResult = AnalyzeResult::fromArray([
                $this->source1 => [
                    10 => LineResult::EXECUTED,
                    11 => LineResult::EXECUTED
                ],
                $this->source2 => [
                    10 => LineResult::EXECUTED,
                    15 => LineResult::UNUSED
                ]
            ]);

            $initEvent = new InitEvent(new Configuration([
                'reportDirectory' => $this->reportDirectory
            ]));
            $this->reporter->onInit($initEvent);

            $this->result = Result::fromAnalyzeResult($analyzeResult);
            $this->stopEvent = new StopEvent($this->result);
            $this->reporter->onStop($this->stopEvent);

            $output  = "";
            $output .= "SF:" . $this->source1 . PHP_EOL;
            $output .= "DA:10,1" . PHP_EOL;
            $output .= "DA:11,1" . PHP_EOL;
            $output .= "end_of_record" . PHP_EOL;

            $output .= "SF:" . $this->source2 . PHP_EOL;
            $output .= "DA:10,1" . PHP_EOL;
            $output .= "DA:15,0" . PHP_EOL;
            $output .= "end_of_record" . PHP_EOL;

            $this->output = $output;
        });
        afterEach(function() {
            unlink($this->reportFile);
        });
        it('should output lcov report file', function() {
            $result = file_get_contents($this->reportFile);
            expect($result)->toEqual($this->output);
        });
    });

});
