<?php

use CodeAnalyzer\Result;
use CodeAnalyzer\Line;

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
            $this->result = new Result();
            $this->returnValue = $this->result->parseResult(array(
                'example.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::UNUSED,
                    3 => Line::DEAD,
                )
            ));
        });
        it('should return CodeAnalyzer\Result instance', function() {
            expect($this->result)->toBeAnInstanceOf('CodeAnalyzer\Result');
        });
    });

    describe('#files', function() {
        it('should return files array');
    });

    describe('#size', function() {
        it('should return files count');
    });

});
