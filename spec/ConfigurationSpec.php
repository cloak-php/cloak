<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Configuration;
use CodeAnalyzer\Result;
use CodeAnalyzer\Result\File;

describe('Configuration', function() {

    describe('#includeFile', function() {
        before(function() {
            $this->configuration = new Configuration();
            $this->returnValue = $this->configuration->includeFile(function(File $file) {});
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

    describe('#includeFiles', function() {
        before(function() {
            $filter1 = function(File $file){};
            $filter2 = function(File $file){};
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->includeFiles(array(
                $filter1, $filter2
            ));
        });
        it('should add filters', function() {
            $filters = $this->configuration->includeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

    describe('#excludeFile', function() {
        before(function() {
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->excludeFile(function(File $file) {});
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

    describe('#excludeFiles', function() {
        before(function() {
            $filter1 = function(File $file){};
            $filter2 = function(File $file){};
            $this->configuration = new Configuration(); 
            $this->returnValue = $this->configuration->excludeFiles(array(
                $filter1, $filter2
            ));
        });
        it('should add filters', function() {
            $filters = $this->configuration->excludeFiles;
            expect(count($filters))->toBe(2);
        });
        it('should return CodeAnalyzer\Configuration instance', function() {
            expect($this->returnValue)->toEqual($this->configuration);
        });
    });

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

            $this->configuration = new Configuration(); 
            $this->configuration->includeFile($filter1)
                ->excludeFile($filter2);

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
