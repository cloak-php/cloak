<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\configuration\Root;
use cloak\configuration\ConfigurationBuilder;
use cloak\reporter\CompositeReporter;


describe(Root::class, function() {

    describe('#applyTo', function() {
        beforeEach(function() {
            $this->builder = new ConfigurationBuilder();
            $this->config = new Root([
                'target' => [
                    'includes' => ['src'],
                    'excludes' => ['vendor']
                ],
                'report' => [
                    'reportDirectory' => '/tmp',
                    'coverageBounds' => [
                        'satisfactory' => 70.0,
                        'critical' => 35.0
                    ]
                ],
                'reporter' => [
                    'lcov' => [
                        'outputFilePath' => __DIR__ . '/../tmp/report.lcov'
                    ],
                    'processingTime' => []
                ]
            ]);
            $this->config->applyTo($this->builder);
        });
        it('return cloak\reporter\CompositeReporter instance', function() {
            expect($this->builder->getReporter())->toBeAnInstanceOf(CompositeReporter::class);
        });
        it('apply output directory path', function() {
            expect($this->builder->getReportDirectory())->toBe('/tmp');
        });
        it('applied includes filters', function() {
            expect($this->builder->getIncludeFiles())->toHaveLength(1);
        });
        it('applied excludes filters', function() {
            expect($this->builder->getExcludeFiles())->toHaveLength(1);
        });
    });

});
