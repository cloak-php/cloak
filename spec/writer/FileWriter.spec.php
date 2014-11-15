<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\writer\FileWriter;

describe('FileWriter', function() {

    beforeEach(function() {
        $this->directory = __DIR__ . '/../tmp/';
        $this->filePath = $this->directory . 'output.txt';
    });

    describe('#__construct', function() {
        context('when directory not found', function() {
            it('throw cloak\writer\DirectoryNotFoundException', function() {
                expect(function() {
                    new FileWriter($this->directory . 'tmp/file.txt');
                })->toThrow('cloak\writer\DirectoryNotFoundException');
            });
        });
        context('when directory not writable', function() {
            beforeEach(function() {
                $this->readOnlyDirectory = $this->directory . 'tmp/';
                mkdir($this->readOnlyDirectory, 0444);
                $this->outputFilePath = $this->readOnlyDirectory . 'file.txt';
            });
            afterEach(function() {
                rmdir($this->readOnlyDirectory);
            });
            it('throw cloak\writer\DirectoryNotWritableException', function() {
                expect(function() {
                    new FileWriter($this->outputFilePath);
                })->toThrow('cloak\writer\DirectoryNotWritableException');
            });
        });
    });

    describe('#writeText', function() {
        beforeEach(function() {
            $this->text = 'text';

            unlink($this->filePath);

            $this->writer = new FileWriter($this->filePath);
            $this->writer->writeText($this->text);

            $this->size = $this->writer->getWriteSize();
        });
        afterEach(function() {
            unlink($this->filePath);
        });
        it('write text', function() {
            expect($this->size)->toEqual(strlen($this->text));
        });
    });

    describe('#writeLine', function() {
        beforeEach(function() {
            $this->text = 'text';

            $this->writer = new FileWriter($this->filePath);
            $this->writer->writeLine($this->text);

            $this->size = $this->writer->getWriteSize();
        });
        afterEach(function() {
            unlink($this->filePath);
        });
        it('write text', function() {
            expect($this->size)->toEqual(strlen($this->text) + 1);
        });
    });

    describe('#writeEOL', function() {
        beforeEach(function() {
            $this->writer = new FileWriter($this->filePath);
            $this->writer->writeEOL();
            $this->content = file_get_contents($this->filePath);
        });
        afterEach(function() {
            unlink($this->filePath);
        });
        it('write empty line', function() {
            expect($this->content)->toEqual(PHP_EOL);
        });
    });

});
