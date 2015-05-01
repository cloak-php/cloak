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
use cloak\configuration\section\Target;


describe(Target::class, function() {
    describe('#applyTo', function() {
        beforeEach(function() {
            $this->builder = new ConfigurationBuilder();
            $this->config = new Target([
                'includes' => ['src'],
                'excludes' => ['vendor', 'spec']
            ]);
            $this->config->applyTo($this->builder);
        });
        it('apply include patterns', function() {
            expect($this->builder->getIncludeFiles())->toHaveLength(1);
        });
        it('apply exclude patterns', function() {
            expect($this->builder->getExcludeFiles())->toHaveLength(2);
        });
    });
});
