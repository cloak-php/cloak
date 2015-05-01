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
use cloak\configuration\section\Report;


describe(Report::class, function() {
    describe('#applyTo', function() {
        beforeEach(function() {
            $this->builder = new ConfigurationBuilder();
            $this->config = new Report([
                'reportDirectory' => '/tmp',
                'coverageBounds' => [
                    'satisfactory' => 70.0,
                    'critical' => 35.0
                ]
            ]);
            $this->config->applyTo($this->builder);
        });
        it('apply output directory path', function() {
            expect($this->builder->getReportDirectory())->toBe('/tmp');
        });
        it('apply coverage bounds', function() {
            $coverageBounds = $this->builder->getCoverageBounds();
            $criticalCoverage = $coverageBounds->getCriticalCoverage();
            $satisfactoryCoverage = $coverageBounds->getSatisfactoryCoverage();
            expect($criticalCoverage->value())->toBe(35.0);
            expect($satisfactoryCoverage->value())->toBe(70.0);
        });
    });
});
