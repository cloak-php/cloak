<?php

use CodeAnalyzer\Line;

describe('Line', function() {

    describe('#isDead', function() {
        context('when status is dead', function() {
            it('should return true', function() {
                $deadLine = new Line(1, Line::DEAD);
                expect($deadLine->isDead())->toBeTrue();
            });
        });
        context('when status is not dead', function() {
            it('should return false', function() {
                $executed = new Line(1, Line::EXECUTED);
                expect($executed->isDead())->toBeFalse();

                $unused = new Line(1, Line::UNUSED);
                expect($unused->isDead())->toBeFalse();
            });
        });
    });

    describe('#isUnused', function() {
        context('when status is unused', function() {
            it('should return true', function() {
                $unused = new Line(1, Line::UNUSED);
                expect($unused->isUnused())->toBeTrue();
            });
        });
        context('when status is not unused', function() {
            it('should return false', function() {
                $executed = new Line(1, Line::EXECUTED);
                expect($executed->isUnused())->toBeFalse();

                $dead = new Line(1, Line::DEAD);
                expect($dead->isUnused())->toBeFalse();
            });
        });
    });

    describe('#isExecuted', function() {
        context('when status is executed', function() {
            it('should return true', function() {
                $unused = new Line(1, Line::EXECUTED);
                expect($unused->isExecuted())->toBeTrue();
            });
        });
        context('when status is not executed', function() {
            it('should return false', function() {
                $unused = new Line(1, Line::UNUSED);
                expect($unused->isExecuted())->toBeFalse();

                $dead = new Line(1, Line::DEAD);
                expect($dead->isExecuted())->toBeFalse();
            });
        });
    });

});
