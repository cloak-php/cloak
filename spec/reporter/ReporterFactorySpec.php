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
use \ReflectionClass;


describe('ReporterFactory', function() {
    before(function() {
        $reporterName = 'cloak\spec\reporter\FixtureReporter';
        $this->reflectionClass = new ReflectionClass($reporterName);
    });
    describe('#fromClassName', function() {
        before(function() {
            $this->reporterName = 'cloak\spec\reporter\FixtureReporter';
        });
        context('when reporter exists', function() {
            before(function() {
                $this->factory = ReporterFactory::fromClassName($this->reporterName);
            });
            it('return cloak\reporter\ReporterFactory instance', function() {
                expect($this->factory)->toBeAnInstanceOf('cloak\reporter\ReporterFactory');
            });
        });
        context('when reporter not exists', function() {
            it('throw \cloak\reporter\ReporterNotFoundException', function() {
                expect(function() {
                    ReporterFactory::fromClassName('NotFoundClass');
                })->toThrow('\cloak\reporter\ReporterNotFoundException');
            });
        });
    });
    describe('#createWithArguments', function() {
        context('when two arguments', function() {
            before(function() {
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
