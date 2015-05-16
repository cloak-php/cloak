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
use cloak\reporter\TreeReporter;
use cloak\analyzer\AnalyzedResult;
use cloak\analyzer\result\LineResult;
use cloak\value\CoverageBounds;
use cloak\event\InitializeEvent;
use cloak\event\StopEvent;


describe(TreeReporter::class, function() {
    describe('onStop', function() {
        beforeEach(function() {
            $rootDirectory = realpath(__DIR__ . '/../../');
            $expectResultFile = __DIR__ . '/../fixtures/report/tree_report.log';

            $expectResult = file_get_contents($expectResultFile);
            $expectResult = str_replace('{rootDirectory}', $rootDirectory, $expectResult);

            $this->expectResult = $expectResult;


            $sourceFile1 = realpath(__DIR__ . '/../fixtures/report/src/Example1.php');
            $sourceFile2 = realpath(__DIR__ . '/../fixtures/report/src/Example2.php');

            $coverages = [
                $sourceFile1 => [
                    13 => LineResult::EXECUTED,
                    18 => LineResult::EXECUTED
                ],
                $sourceFile2 => [
                    13 => LineResult::EXECUTED,
                    18 => LineResult::UNUSED
                ]
            ];

            $analyzeResult = AnalyzedResult::fromArray($coverages);
            $this->stopEvent = new StopEvent(Result::fromAnalyzeResult($analyzeResult));

            $config = new Configuration([
                'coverageBounds' => new CoverageBounds(35.0, 70.0)
            ]);
            $initEvent = new InitializeEvent($config);

            $this->reporter = new TreeReporter();
            $this->reporter->onInitialize($initEvent);
        });
        it('output tree result', function() {
            expect(function() {
                $this->reporter->onStop($this->stopEvent);
            })->toPrint($this->expectResult);
        });
    });

});
