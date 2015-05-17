<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\AnalyzedCoverageResult;
use cloak\Configuration;
use cloak\analyzer\result\LineResult;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\reporter\LcovReporter;
use cloak\analyzer\AnalyzedResult;
use \DateTime;


describe(LcovReporter::class, function() {
    describe('onStop', function() {
        beforeEach(function() {
            $this->reportDirectory = $this->makeDirectory();
            $this->reportFileName = 'report.lcov';
            $this->reportFile = $this->reportDirectory->getPath() . '/report.lcov';
            $this->reporter = new LcovReporter($this->reportFileName);

            $this->source1 = realpath(__DIR__ . '/../fixtures/Example1.php');
            $this->source2 = realpath(__DIR__ . '/../fixtures/Example2.php');

            $analyzeResult = AnalyzedResult::fromArray([
                $this->source1 => [
                    10 => LineResult::EXECUTED,
                    11 => LineResult::EXECUTED
                ],
                $this->source2 => [
                    10 => LineResult::EXECUTED,
                    15 => LineResult::UNUSED
                ]
            ]);

            $initEvent = new InitializeEvent(new Configuration([
                'reportDirectory' => $this->reportDirectory->getPath()
            ]));
            $this->reporter->onInitialize($initEvent);

            $this->result = AnalyzedCoverageResult::fromAnalyzeResult($analyzeResult);
            $this->stopEvent = new AnalyzeStopEvent($this->result);
            $this->reporter->onAnalyzeStop($this->stopEvent);

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
        it('should output lcov report file', function() {
            $result = file_get_contents($this->reportFile);
            expect($result)->toEqual($this->output);
        });
    });

});
