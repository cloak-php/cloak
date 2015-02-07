<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\configuration\ConfigurationBuilder;
use cloak\reporter\TextReporter;
use \Prophecy\Prophet;


describe('ConfigurationBuilder', function() {

    describe('#includeFiles', function() {
        beforeEach(function() {
            $filePatterns = [ 'src', 'lib' ];

            $this->builder = new ConfigurationBuilder();
            $this->returnValue = $this->builder->includeFiles($filePatterns);
        });
        it('add filter patterns', function() {
            $filters = $this->builder->includeFiles;
            expect(count($filters))->toEqual(2);
        });
        it('return cloak\ConfigurationBuilder instance', function() {
            expect($this->returnValue)->toEqual($this->builder);
        });
    });

    describe('#excludeFiles', function() {
        beforeEach(function() {
            $filePatterns = [ 'spec', 'tmp' ];

            $this->builder = new ConfigurationBuilder();
            $this->returnValue = $this->builder->excludeFiles($filePatterns);
        });
        it('add filter patterns', function() {
            $filters = $this->builder->excludeFiles;
            expect(count($filters))->toEqual(2);
        });
        it('return cloak\ConfigurationBuilder instance', function() {
            expect($this->returnValue)->toEqual($this->builder);
        });
    });

    describe('#build', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $driver = $this->prophet->prophesize('cloak\driver\DriverInterface');
            $driver->start()->shouldNotBeCalled();
            $driver->stop()->shouldNotBeCalled();

            $this->driver = $driver->reveal();

            $this->reporter = new TextReporter();

            $includePatterns = [ 'src', 'lib' ];
            $excludePatterns = [ 'spec', 'tmp' ];

            $this->builder = new ConfigurationBuilder();
            $this->builder->driver( $this->driver )
                ->reporter($this->reporter)
                ->includeFiles($includePatterns)
                ->excludeFiles($excludePatterns);

            $this->returnValue = $this->builder->build();
        });
        it('return cloak\Configuration instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Configuration');
        });
        it('apply driver configration', function() {
            $this->prophet->checkPredictions();

            $driver = $this->returnValue->getDriver();
            expect($driver)->toEqual($this->driver);
        });
        it('apply reporter configration', function() {
            $reporter = $this->returnValue->getReporter();
            expect($reporter)->toEqual($this->reporter);
        });
        it('apply includeFiles configration', function() {
            $filters = $this->returnValue->getIncludeFiles();
            expect($filters)->toHaveLength(2);
        });
        it('apply excludeFiles configration', function() {
            $filters = $this->returnValue->getExcludeFiles();
            expect($filters)->toHaveLength(2);
        });
    });

});
