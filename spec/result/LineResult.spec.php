<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\LineResult;
use cloak\result\FileResult;
use cloak\result\collection\LineResultCollection;


describe(LineResult::class, function() {

    beforeEach(function() {
        $this->file = new FileResult(__DIR__ . '/../fixtures/src/foo.php', new LineResultCollection);
        $this->deadLine = new LineResult(1, LineResult::DEAD, $this->file);
        $this->unusedLine = new LineResult(1, LineResult::UNUSED, $this->file);
        $this->executedLine = new LineResult(1, LineResult::EXECUTED, $this->file);
    });

    describe('#getAnalyzeResult', function() {
        it('should return result status', function() {
            expect($this->deadLine->getAnalyzeResult())->toEqual(LineResult::DEAD);
            expect($this->unusedLine->getAnalyzeResult())->toEqual(LineResult::UNUSED);
            expect($this->executedLine->getAnalyzeResult())->toEqual(LineResult::EXECUTED);
        });
    });

    describe('#link', function() {
        beforeEach(function() {
            $this->linkLine = new LineResult(5, LineResult::EXECUTED);
            $this->linkLine->link($this->file);
        });
        it('should link to file', function() {
            expect($this->linkLine->getFile())->toEqual($this->file);
            expect($this->linkLine->isFileAssociated())->toBeTrue();
        });
    });

    describe('#unlink', function() {
        beforeEach(function() {
            $this->linkLine = new LineResult(5, LineResult::EXECUTED);
            $this->linkLine->link($this->file);
            $this->linkLine->unlink();
        });
        it('should link to file', function() {
            expect($this->linkLine->getFile())->toBeNull();
            expect($this->linkLine->isFileAssociated())->toBeFalse();
        });
    });

    describe('#equals', function() {
        context('when file and line number at the same', function() {
            it('should return true', function() {
                expect($this->deadLine->equals($this->unusedLine))->toBeTrue();
            });
        });
        context('when file and line number are not the same', function() {
            it('should return false', function() {
                $this->unusedLine->unlink();
                expect($this->deadLine->equals($this->unusedLine))->toBeFalse();
            });
        });
    });

    describe('#isDead', function() {
        context('when status is dead', function() {
            it('should return true', function() {
                expect($this->deadLine->isDead())->toBeTrue();
            });
        });
        context('when status is not dead', function() {
            it('should return false', function() {
                expect($this->unusedLine->isDead())->toBeFalse();
                expect($this->executedLine->isDead())->toBeFalse();
            });
        });
    });

    describe('#isUnused', function() {
        context('when status is unused', function() {
            it('should return true', function() {
                expect($this->unusedLine->isUnused())->toBeTrue();
            });
        });
        context('when status is not unused', function() {
            it('should return false', function() {
                expect($this->deadLine->isUnused())->toBeFalse();
                expect($this->executedLine->isUnused())->toBeFalse();
            });
        });
    });

    describe('#isExecuted', function() {
        context('when status is executed', function() {
            it('should return true', function() {
                expect($this->executedLine->isExecuted())->toBeTrue();
            });
        });
        context('when status is not executed', function() {
            it('should return false', function() {
                expect($this->deadLine->isExecuted())->toBeFalse();
                expect($this->unusedLine->isExecuted())->toBeFalse();
            });
        });
    });

    describe('#isValid', function() {
        beforeEach(function() {
            $this->validLine = new LineResult(1, LineResult::EXECUTED);
            $this->lineNumberInvalidLine = new LineResult(0, LineResult::EXECUTED);
            $this->statusInvalidLine = new LineResult(1, 99);
        });

        context('when an valid line result', function() {
            it('should return true', function() {
                expect($this->validLine->isValid())->toBeTrue();
            });
        });
        context('when an invalid line result', function() {
            it('should return false', function() {
                expect($this->lineNumberInvalidLine->isValid())->toBeFalse();
                expect($this->statusInvalidLine->isValid())->toBeFalse();
            });
        });
    });

});
