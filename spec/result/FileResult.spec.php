<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\FileResult;
use cloak\result\LineResult;
use cloak\result\collection\LineResultCollection;
use cloak\result\LineResultCollectionInterface;
use cloak\result\collection\CoverageResultCollection;


describe(LineResultCollectionInterface::class, function() {

    describe('#getRelativePath', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection();
            $this->file = new FileResult(__FILE__, $this->lineSet);
        });
        it('should return relative path', function() {
            expect($this->file->getRelativePath(__DIR__))->toEqual('FileResult.spec.php');
        });
    });

    describe('#getLineResults', function() {
        context('when line is empty', function() {
            beforeEach(function() {
                $this->lineSet = new LineResultCollection();
                $this->file = new FileResult(__DIR__ . '/../fixtures/src/foo.php', $this->lineSet);
            });
            it('return cloak\result\LineResultCollectionInterface instance', function() {
                expect($this->file->getLineResults())->toBeAnInstanceOf(LineResultCollectionInterface::class);
            });
        });
        context('when line is not empty', function() {
            beforeEach(function() {
                $this->lineSet = new LineResultCollection([
                    new LineResult(12, LineResult::EXECUTED),
                    new LineResult(17, LineResult::UNUSED)
                ]);
                $this->file = new FileResult(__DIR__ . '/../fixtures/src/foo.php', $this->lineSet);
            });
            it('should return cloak\result\LineResultCollectionInterface instance', function() {
                expect($this->file->getLineResults())->toBeAnInstanceOf(LineResultCollectionInterface::class);
            });
            it('should return cloak\result\LineResultCollectionInterface instance', function() {
                expect($this->file->getLineResults()->getLineCount())->toEqual(2);
            });
        });
    });

    describe('#equals', function() {
        context('when path equals', function() {
            beforeEach(function() {
                $this->lineSet1 = new LineResultCollection();
                $this->lineSet2 = new LineResultCollection();

                $this->file1 = new FileResult(__DIR__ . '/../fixtures/src/foo.php', $this->lineSet1);
                $this->file2 = new FileResult(__DIR__ . '/../fixtures/src/foo.php', $this->lineSet2);
            });
            it('should return true', function() {
                $result = $this->file1->equals($this->file2);
                expect($result)->toBeTrue();
            });
        });
    });

    describe('#matchPath', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection();
            $this->file = new FileResult(__DIR__ . '/../fixtures/src/foo.php', $this->lineSet);
        });
        context('when included in the path', function() {
            it('should return true', function() {
                $result = $this->file->matchPath('/foo');
                expect($result)->toBeTrue();
            });
        });
        context('when not included in the path', function() {
            it('should return false', function() {
                $result = $this->file->matchPath('/bar');
                expect($result)->toBeFalse();
            });
        });
    });

    describe('getClassResults', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(12, LineResult::EXECUTED),
                new LineResult(17, LineResult::UNUSED)
            ]);
            $this->file = new FileResult(__DIR__ . '/../fixtures/src/foo.php', $this->lineSet);

        });
        it('return \cloak\result\collection\CoverageResultCollection instance', function() {
            expect($this->file->getClassResults())->toBeAnInstanceOf(CoverageResultCollection::class);
        });
    });

});
