<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Configuration;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Reporter\TextReporter;

describe('ConfigurationBuilder', function() {

    describe('#includeFiles', function() {
        before(function() {
            $filter1 = function(File $file){};
            $filter2 = function(File $file){};
            $this->builder = new ConfigurationBuilder(); 
            $this->returnValue = $this->builder->includeFiles(array(
                $filter1, $filter2
            ));
        });
        it('should add filters', function() {
            $filters = $this->builder->includeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\ConfigurationBuilder instance', function() {
            expect($this->returnValue)->toEqual($this->builder);
        });
    });

    describe('#excludeFiles', function() {
        before(function() {
            $filter1 = function(File $file){};
            $filter2 = function(File $file){};
            $this->builder = new ConfigurationBuilder(); 
            $this->returnValue = $this->builder->excludeFiles(array(
                $filter1, $filter2
            ));
        });
        it('should add filters', function() {
            $filters = $this->builder->excludeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\ConfigurationBuilder instance', function() {
            expect($this->returnValue)->toEqual($this->builder);
        });
    });

    describe('#build', function() {
        before(function() {
            $this->filter1 = function(File $file){};
            $this->filter2 = function(File $file){};
            $this->filter3 = function(File $file){};
            $this->filter4 = function(File $file){};
            $this->reporter = new TextReporter();

            $this->builder = new ConfigurationBuilder(); 
            $this->builder->reporter($this->reporter)
                ->includeFiles(array( $this->filter1, $this->filter2 ))
                ->excludeFiles(array( $this->filter3, $this->filter4 ));

            $this->returnValue = $this->builder->build();
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('CodeAnalyzer\Configuration');
        });
        it('should apply reporter configration', function() {
            $reporter = $this->returnValue->reporter;
            expect($reporter)->toEqual($this->reporter);
        });
        it('should apply includeFiles configration', function() {
            $filters = $this->returnValue->includeFiles;
            expect($filters[0])->toEqual($this->filter1);
            expect($filters[1])->toEqual($this->filter2);
        });
        it('should apply excludeFiles configration', function() {
            $filters = $this->returnValue->excludeFiles;
            expect($filters[0])->toEqual($this->filter3);
            expect($filters[1])->toEqual($this->filter4);
        });
    });

});
