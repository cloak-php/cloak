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
use cloak\configuration\Target;


describe('Target', function() {

    describe('#applyTo', function() {
        before(function() {
            $this->builder = new ConfigurationBuilder();
            $this->config = new Target([
                'includes' => ['src'],
                'excludes' => ['vendor', 'spec']
            ]);
            $this->config->applyTo($this->builder);
        });
        it('applied includes filters', function() {
            expect($this->builder->includeFiles)->toHaveLength(1);
        });
        it('applied excludes filters', function() {
            expect($this->builder->excludeFiles)->toHaveLength(1);
        });
    });

});
