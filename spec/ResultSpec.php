<?php

use CodeAnalyzer\Result;

describe('Result', function() {

    $this->returnValue = null;

    describe('#from', function() {
        before(function() {
            $this->returnValue = Result::from(array(
            ));
        });
        it('should return CodeAnalyzer\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('CodeAnalyzer\Result');
        });
    });

});
