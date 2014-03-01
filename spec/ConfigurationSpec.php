<?php

use CodeAnalyzer\Configuration;
use CodeAnalyzer\File;

describe('Configuration', function() {

    describe('#collect', function() {
        before(function() {
            $this->configuration = new Configuration(); 
            $this->returnValue = null;
        });
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
        before(function() {
            $this->configuration = new Configuration(); 
            $this->returnValue = null;
        });
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
                $this->returnValue = $this->configuration->includeFile(function(File $file) {
                });
            });
            it('should return CodeAnalyzer\Configuration instance', function() {
                expect($this->returnValue)->toEqual($this->configuration);
            });
        });
    });

    describe('#includeFiles', function() {
        before(function() {
            $filter1 = function(File $file){};
            $filter2 = function(File $file){};
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->includeFiles(array(
                $filter1, $filter2
            ));
        });
        it('should add filters', function() {
            $filters = $this->configuration->getIncludeFilters();
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

    describe('#excludeFile', function() {
        before(function() {
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->excludeFile();
        });
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
                $this->returnValue = $this->configuration->excludeFile(function(File $file) {
                });
            });
            it('should return CodeAnalyzer\Configuration instance', function() {
                expect($this->returnValue)->toEqual($this->configuration);
            });
        });
    });

    describe('#excludeFiles', function() {
        before(function() {
            $filter1 = function(File $file){};
            $filter2 = function(File $file){};
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->excludeFiles(array(
                $filter1, $filter2
            ));
        });
        it('should add filters', function() {
            $filters = $this->configuration->getExcludeFilters();
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

});
