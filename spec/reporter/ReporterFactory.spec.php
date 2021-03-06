<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\reporter\ReporterFactory;
use cloak\reporter\ReporterNotFoundException;
use cloak\spec\reporter\ReporterFixture;


describe(ReporterFactory::class, function() {
    beforeEach(function() {
        $this->reporterName = ReporterFixture::class;
        $this->reflectionClass = new ReflectionClass($this->reporterName);
    });
    describe('#fromClassName', function() {
        context('when reporter exists', function() {
            beforeEach(function() {
                $this->factory = ReporterFactory::fromClassName($this->reporterName);
            });
            it('return cloak\reporter\ReporterFactory instance', function() {
                expect($this->factory)->toBeAnInstanceOf(ReporterFactory::class);
            });
        });
        context('when reporter not exists', function() {
            it('throw \cloak\reporter\ReporterNotFoundException', function() {
                expect(function() {
                    ReporterFactory::fromClassName('NotFoundClass');
                })->toThrow(ReporterNotFoundException::class);
            });
        });
    });
    describe('#createWithArguments', function() {
        context('when two arguments', function() {
            beforeEach(function() {
                $factory = new ReporterFactory($this->reflectionClass);
                $reporter = $factory->createWithArguments([
                    'description' => 'description text',
                    'name' => 'name text'
                ]);
                $this->reporter = $reporter;
            });
            it('assign first argument value', function() {
                expect($this->reporter->getName())->toEqual('name text');
            });
            it('assign second argument value', function() {
                expect($this->reporter->getDescription())->toEqual('description text');
            });
        });
    });
});
