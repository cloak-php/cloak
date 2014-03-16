<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Result\Line,
    CodeAnalyzer\Result\File;

describe('Line', function() {

    before(function() {
        $this->file = new File('some.php');
        $this->deadLine = new Line(1, Line::DEAD, $this->file);
        $this->unusedLine = new Line(1, Line::UNUSED, $this->file);
        $this->executedLine = new Line(1, Line::EXECUTED, $this->file);
    });

    describe('#link', function() {
        before(function() {
            $this->linkLine = new Line(5, Line::EXECUTED);
            $this->linkLine->link($this->file);
        });
        it('should link to file', function() {
            expect($this->linkLine->getFile())->toEqual($this->file);
        });
    });

    describe('#unlink', function() {
        before(function() {
            $this->linkLine = new Line(5, Line::EXECUTED);
            $this->linkLine->link($this->file);
            $this->linkLine->unlink();
        });
        it('should link to file', function() {
            expect($this->linkLine->getFile())->toBeNull();
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

});
