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
use cloak\Configuration;
use cloak\driver\Result;
use cloak\driver\result\File;


describe('Configuration', function() {

    describe('#__constrcut', function() {
        context('when specify a property that does not exist', function() {
            it('throw InvalidArgumentException', function() {
                expect(function() {
                    new Configuration([
                        'invalid_property' => ''
                    ]);
                })->toThrow('\InvalidArgumentException');
            });
        });
    });

    describe('#applyTo', function() {
        $filter1 = function(File $file) {
            return $file->matchPath('foo');
        };
        $filter2 = function(File $file) {
            return $file->matchPath('vendor/foo1.php');
        };

        $rootDirectory = __DIR__ . '/fixtures/src/';

        $this->result = new Result();
        $this->result->add(new File($rootDirectory . 'foo.php', []));
        $this->result->add(new File($rootDirectory . 'bar.php', []));
        $this->result->add(new File($rootDirectory . 'vendor/foo1.php',  []));

        $builder = new ConfigurationBuilder();
        $this->configuration = $builder->includeFile($filter1)
            ->excludeFile($filter2)
            ->build();

        $this->returnValue = $this->configuration->applyTo($this->result);

        it('apply configuration', function() {
            $files = $this->returnValue->getFiles();
            $values = $files->last()->get();
            $file = array_pop($values);
            expect($files->count())->toBe(1);
            expect($file->matchPath('/foo.php'))->toBeTrue();
        });
        it('return cloak\driver\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\driver\Result');
        });
    });

});
