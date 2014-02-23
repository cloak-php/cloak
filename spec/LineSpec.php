<?php

use CodeAnalyzer\Line;

describe('Line', function() {

    before(function() {
        $this->deadLine = new Line(1, Line::DEAD);
        $this->unusedLine = new Line(1, Line::UNUSED);
        $this->executedLine = new Line(1, Line::EXECUTED);
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
