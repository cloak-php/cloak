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
use cloak\configuration\Root;


describe('Root', function() {

    describe('#applyTo', function() {
        before(function() {
            $this->builder = new ConfigurationBuilder();
            $this->config = new Root([
                'target' => [
                    'includes' => ['src'],
                    'excludes' => ['vendor']
                ],
                'reporter' => [
                    'lcov' => [
                        'outputFilePath' => 'report.lcov'
                    ],
                    'processingTime' => []
                ]
            ]);
            $this->config->applyTo($this->builder);
        });
        it('return cloak\reporter\CompositeReporter instance', function() {
            expect($this->builder->reporter)->toBeAnInstanceOf('cloak\reporter\CompositeReporter');
        });
        it('applied includes filters', function() {
            expect($this->builder->includeFiles)->toHaveLength(1);
        });
        it('applied excludes filters', function() {
            expect($this->builder->excludeFiles)->toHaveLength(1);
        });
    });

});
