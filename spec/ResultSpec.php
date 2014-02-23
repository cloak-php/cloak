<?php

use CodeAnalyzer\Result;
use CodeAnalyzer\Line;
use CodeAnalyzer\File;

describe('Result', function() {

    $this->returnValue = null;

    describe('#from', function() {
        before(function() {
            $this->returnValue = Result::from(array(
                'example.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                )
            ));
        });
        it('should return CodeAnalyzer\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('CodeAnalyzer\Result');
        });
    });

    describe('#parseResult', function() {
        before(function() {
            $this->returnValue = Result::parseResult(array(
                'example.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                )
            ));
        });
        it('should return PhpCollection\Sequence instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('PhpCollection\Sequence');
        });
    });

    describe('#includeFile', function() {
        before(function() {

            $this->result = Result::from(array(
                'example1.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                ),
                'example2.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                )
            ));
            $this->returnValue = $this->result->includeFile(function(File $file) {
                return $file->getPath() === 'example2.php';
            });
        });
        it('should return PhpCollection\Sequence instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('PhpCollection\Sequence');
        });
        it('should include only those that match element', function() {
            expect($this->returnValue->count())->toBe(1);
            expect($this->returnValue->last()->get()->getPath())->toEqual('example2.php');
        });
    });

    describe('#excludeFile', function() {
        before(function() {
            $this->result = Result::from(array(
                'example1.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                ),
                'example2.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                )
            ));
            $this->returnValue = $this->result->excludeFile(function(File $file) {
                return $file->getPath() === 'example2.php';
            });
        });
        it('should return PhpCollection\Sequence instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('PhpCollection\Sequence');
        });
        it('should exclude only those that match element', function() {
            expect($this->returnValue->count())->toBe(1);
            expect($this->returnValue->last()->get()->getPath())->toEqual('example1.php');
        });
    });

});
