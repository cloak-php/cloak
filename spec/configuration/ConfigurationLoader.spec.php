<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Configuration;
use cloak\configuration\ConfigurationLoader;
use cloak\configuration\ConfigurationFileNotFoundException;


describe(ConfigurationLoader::class, function() {

    describe('#loadConfiguration', function() {
        beforeEach(function() {
            $this->loader = new ConfigurationLoader();
        });
        context('when file exists', function() {
            beforeEach(function() {
                $this->configFile = realpath(__DIR__ . '/../fixtures/config.toml');
                $this->config = $this->loader->loadConfiguration($this->configFile);
            });
            it('return cloak\Configuration instance', function() {
                expect($this->config)->toBeAnInstanceOf(Configuration::class);
            });
        });
        context('when file not exists', function() {
          beforeEach(function() {
              $this->configFile = realpath(__DIR__ . '/../fixtures/not_found_config.toml');
          });
          it('throw \cloak\configuration\ConfigurationFileNotFoundException', function() {
              expect(function() {
                  $this->loader->loadConfiguration($this->configFile);
              })->toThrow(ConfigurationFileNotFoundException::class);
          });
        });
    });

});
