<?php

use CodeAnalyzer\Configuration;
use CodeAnalyzer\File;

describe('Configuration', function() {

    describe('#includeFile', function() {
        before(function() {
            $this->configuration = new Configuration();
            $this->returnValue = $this->configuration->includeFile(function(File $file) {});
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
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
            $filters = $this->configuration->includeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

    describe('#excludeFile', function() {
        before(function() {
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->excludeFile(function(File $file) {});
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
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
            $filters = $this->configuration->excludeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

});
