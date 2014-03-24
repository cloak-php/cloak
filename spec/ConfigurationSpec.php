<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Configuration,
    CodeAnalyzer\ConfigurationBuilder,
    CodeAnalyzer\Result,
    CodeAnalyzer\Result\File;

describe('Configuration', function() {

    describe('#apply', function() {
        before(function() {
            $filter1 = function(File $file) {
                return $file->matchPath('test');
            };
            $filter2 = function(File $file) {
                return $file->matchPath('test2');
            };
            $this->result = new Result();
            $this->result->addFile(new File('test1.php'));
            $this->result->addFile(new File('test2.php'));
            $this->result->addFile(new File('example3.php'));

            $builder = new ConfigurationBuilder();
            $this->configuration = $builder->includeFile($filter1)
                ->excludeFile($filter2)
                ->build();

            $this->returnValue = $this->configuration->apply($this->result);
        });
        it('should apply configuration', function() {
            $files = $this->returnValue->getFiles();
            expect($files->count())->toBe(1);
            expect($files->last()->get()->getPath())->toEqual('test1.php');
        });
        it('should return CodeAnalyzer\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('CodeAnalyzer\Result');
        });
    });

});
