<?php

/**
 * This file is part of easycoverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use easycoverage\ConfigurationBuilder;
use easycoverage\Result;
use easycoverage\result\File;

describe('Configuration', function() {

    describe('#apply', function() {
        $filter1 = function(File $file) {
            return $file->matchPath('foo');
        };
        $filter2 = function(File $file) {
            return $file->matchPath('vendor/foo1.php');
        };

        $rootDirectory = __DIR__ . '/fixtures/src/';

        $this->result = new Result();
        $this->result->addFile(new File($rootDirectory . 'foo.php'));
        $this->result->addFile(new File($rootDirectory . 'bar.php'));
        $this->result->addFile(new File($rootDirectory . 'vendor/foo1.php'));

        $builder = new ConfigurationBuilder();
        $this->configuration = $builder->includeFile($filter1)
            ->excludeFile($filter2)
            ->build();

        $this->returnValue = $this->configuration->apply($this->result);

        it('should apply configuration', function() {
            $files = $this->returnValue->getFiles();
            expect($files->count())->toBe(1);
            expect($files->last()->get()->matchPath('/foo.php'))->toBeTrue();
        });
        it('should return easycoverage\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('easycoverage\Result');
        });
    });

});
