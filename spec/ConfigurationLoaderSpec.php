<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\ConfigurationLoader;

describe('ConfigurationLoader', function() {

    describe('#loadConfiguration', function() {
        before(function() {
            $this->configFile = realpath(__DIR__ . '/fixtures/config.toml');
            $this->loader = new ConfigurationLoader();
            $this->config = $this->loader->loadConfiguration($this->configFile);
        });
        it('return cloak\Configuration instance', function() {
            expect($this->config)->toBeAnInstanceOf('cloak\Configuration');
        });
    });

});
