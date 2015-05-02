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
use cloak\value\Coverage;
use cloak\result\LineResult;
use cloak\result\FileResult;
use cloak\result\collection\LineResultCollection;
use cloak\driver\Result as AnalyzeResult;


describe(Result::class, function() {

    beforeEach(function() {
        $this->rootDirectory = __DIR__ . '/fixtures/src/';
        $this->returnValue = null;
    });

    describe('#fromAnalyzeResult', function() {
        beforeEach(function() {
            $analyzeResult = AnalyzeResult::fromArray([
                $this->rootDirectory . 'foo.php' => [
                    1 => LineResult::EXECUTED
                ]
            ]);
            $this->returnValue = Result::fromAnalyzeResult($analyzeResult);
        });

        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf(Result::class);
        });
    });

    describe('summary', function() {
        beforeEach(function() {
            $filePath1 = $this->rootDirectory . 'foo.php';
            $filePath2 = $this->rootDirectory . 'bar.php';
            $file1 = new FileResult($filePath1, new LineResultCollection([
                new LineResult(10, LineResult::DEAD),
                new LineResult(12, LineResult::EXECUTED),
                new LineResult(17, LineResult::UNUSED)
            ]));
            $file2 = new FileResult($filePath2, new LineResultCollection([
                new LineResult(1, LineResult::UNUSED)
            ]));

            $this->result = new Result([$file1, $file2]);
        });

        describe('#getLineCount', function() {
            it('return total line count', function() {
                expect($this->result->getLineCount())->toEqual(33);
            });
        });

        describe('#getDeadLineCount', function() {
            it('return total dead line count', function() {
                expect($this->result->getDeadLineCount())->toEqual(1);
            });
        });

        describe('#getUnusedLineCount', function() {
            it('return total unused line count', function() {
                expect($this->result->getUnusedLineCount())->toEqual(2);
            });
        });

        describe('#getExecutedLineCount', function() {
            it('return total executed line count', function() {
                expect($this->result->getExecutedLineCount())->toEqual(1);
            });
        });

        describe('#getExecutableLineCount', function() {
            it('return total executable line count', function() {
                expect($this->result->getExecutableLineCount())->toEqual(3);
            });
        });

        describe('#getCodeCoverage', function() {
            it('return total code coverage', function() {
                expect($this->result->getCodeCoverage()->value())->toEqual(33.33);
            });
        });

        describe('#isCoverageLessThan', function() {
            context('when less than', function() {
                beforeEach(function() {
                    $this->coverage = new Coverage(34.0);
                    $this->result = $this->result->isCoverageLessThan($this->coverage);
                });
                it('return true', function () {
                    expect($this->result)->toBeTrue();
                });
            });
        });

        describe('#isCoverageGreaterEqual', function() {
            context('when greater equal', function() {
                beforeEach(function() {
                    $this->coverage = new Coverage(33.33);
                    $this->result = $this->result->isCoverageGreaterEqual($this->coverage);
                });
                it('return true', function () {
                    expect($this->result)->toBeTrue();
                });
            });
        });
    });

});
