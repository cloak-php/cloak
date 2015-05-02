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
use cloak\configuration\section\Reporter;
use cloak\reporter\CompositeReporter;

describe(Reporter::class, function() {

    describe('#applyTo', function() {
        beforeEach(function() {
            $this->builder = new ConfigurationBuilder();
            $this->config = new Reporter([
                'lcov' => [
                    'outputFilePath' => __DIR__ . '/../../tmp/report.lcov'
                ],
                'processingTime' => []
            ]);
            $this->config->applyTo($this->builder);
        });
        it('return cloak\reporter\CompositeReporter instance', function() {
            expect($this->builder->getReporter())->toBeAnInstanceOf(CompositeReporter::class);
        });
    });

});
