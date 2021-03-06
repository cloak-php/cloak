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
use cloak\AnalyzerConfiguration;
use cloak\reporter\TextReporter;
use cloak\analyzer\AnalyzedResult;
use cloak\analyzer\result\LineResult;
use cloak\value\CoverageBounds;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStopEvent;


describe(TextReporter::class, function() {
    describe('onAnalyzeStop', function() {
        beforeEach(function() {
            $expectResultFile = __DIR__ . '/../fixtures/report/text_report.log';
            $this->expectResult = file_get_contents($expectResultFile);

            $sourceFile1 = realpath(__DIR__ . '/../fixtures/report/src/Example1.php');
            $sourceFile2 = realpath(__DIR__ . '/../fixtures/report/src/Example2.php');
            $sourceFile3 = realpath(__DIR__ . '/../fixtures/report/src/Example3.php');

            $coverages = [
                $sourceFile1 => [
                    13 => LineResult::EXECUTED,
                    18 => LineResult::EXECUTED
                ],
                $sourceFile2 => [
                    13 => LineResult::EXECUTED,
                    18 => LineResult::UNUSED
                ],
                $sourceFile3 => [
                    13 => LineResult::UNUSED,
                    18 => LineResult::UNUSED
                ]
            ];

            $analyzeResult = AnalyzedResult::fromArray($coverages);
            $this->stopEvent = new AnalyzeStopEvent(AnalyzedCoverageResult::fromAnalyzeResult($analyzeResult));

            $config = new AnalyzerConfiguration([
                'coverageBounds' => new CoverageBounds(35.0, 70.0)
            ]);
            $initEvent = new InitializeEvent($config);

            $this->reporter = new TextReporter();
            $this->reporter->onInitialize($initEvent);
        });
        it('output text report', function() {
            expect(function() {
                $this->reporter->onAnalyzeStop($this->stopEvent);
            })->toPrint($this->expectResult);
        });
    });
});
