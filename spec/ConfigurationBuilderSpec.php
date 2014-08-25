<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\ConfigurationBuilder;
use cloak\reporter\TextReporter;
use \Mockery;

describe('ConfigurationBuilder', function() {

    describe('#includeFiles', function() {
        before(function() {
            $this->filter1 = function(File $file){};
            $this->filter2 = function(File $file){};
            $this->builder = new ConfigurationBuilder();
            $this->returnValue = $this->builder->includeFiles([
                $this->filter1, $this->filter2
            ]);
        });
        it('should add filters', function() {
            $filters = $this->builder->includeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return cloak\ConfigurationBuilder instance', function() {
            expect($this->returnValue)->toEqual($this->builder);
        });
    });

    describe('#excludeFiles', function() {
        before(function() {
            $this->filter1 = function(File $file){};
            $this->filter2 = function(File $file){};
            $this->builder = new ConfigurationBuilder();
            $this->returnValue = $this->builder->excludeFiles([
                $this->filter1, $this->filter2
            ]);
        });
        it('should add filters', function() {
            $filters = $this->builder->excludeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return cloak\ConfigurationBuilder instance', function() {
            expect($this->returnValue)->toEqual($this->builder);
        });
    });

    describe('#build', function() {
        before(function() {
            $this->verify = function() {
                Mockery::close();
            };

            $this->filter1 = function(File $file){};
            $this->filter2 = function(File $file){};
            $this->filter3 = function(File $file){};
            $this->filter4 = function(File $file){};

            $this->reporter = new TextReporter();

            $this->driver = Mockery::mock('cloak\driver\DriverInterface');
            $this->driver->shouldReceive('start')->never();
            $this->driver->shouldReceive('stop')->never();

            $this->builder = new ConfigurationBuilder();
            $this->builder->driver($this->driver)
                ->reporter($this->reporter)
                ->includeFiles(array( $this->filter1, $this->filter2 ))
                ->excludeFiles(array( $this->filter3, $this->filter4 ));

            $this->returnValue = $this->builder->build();
        });
        it('should return cloak\Configuration instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Configuration');
        });
        it('should apply driver configration', function() {
            $driver = $this->returnValue->driver;
            expect($driver)->toEqual($this->driver);
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
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

});
