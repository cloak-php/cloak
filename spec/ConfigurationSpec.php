<?php

use CodeAnalyzer\Configuration;

describe('Configuration', function() {

    $this->returnValue = null;
    $this->configuration = new Configuration(); 

    describe('#collect', function() {
        context('when arguments is null', function() {
            before(function() {
                $this->returnValue = $this->configuration->collect();
            });
            it('should return collect option value', function() {
                expect($this->returnValue)->toEqual(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
            });
        });
        context('when arguments is not null', function() {
            before(function() {
                $this->returnValue = $this->configuration->collect(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
            });
            it('should return CodeAnalyzer\Configuration instance', function() {
                expect($this->returnValue)->toEqual($this->configuration);
            });
        });
    });

    describe('#includeFile', function() {
        context('when arguments is null', function() {
            before(function() {
                $this->returnValue = $this->configuration->includeFile();
            });
            it('should return callback filter', function() {
                expect($this->returnValue)->toEqual(array());
            });
        });
        context('when arguments is not null', function() {
            before(function() {
                $this->returnValue = $this->configuration->includeFile(function($file) {
                });
            });
            it('should return CodeAnalyzer\Configuration instance', function() {
                expect($this->returnValue)->toEqual($this->configuration);
            });
        });
    });

    describe('#excludeFile', function() {
        context('when arguments is null', function() {
            before(function() {
                $this->returnValue = $this->configuration->excludeFile();
            });
            it('should return callback filter', function() {
                expect($this->returnValue)->toEqual(array());
            });
        });
        context('when arguments is not null', function() {
            before(function() {
                $this->returnValue = $this->configuration->excludeFile(function($file) {
                });
            });
            it('should return CodeAnalyzer\Configuration instance', function() {
                expect($this->returnValue)->toEqual($this->configuration);
            });
        });
    });

});
