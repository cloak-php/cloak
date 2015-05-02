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
use cloak\writer\DirectoryNotFoundException;
use cloak\writer\DirectoryNotWritableException;

describe(FileWriter::class, function() {
    describe('#__construct', function() {
        beforeEach(function() {
            $this->directory = $this->makeDirectory();
            $this->filePath = $this->directory->resolvePath('output.txt');
        });
        context('when directory not found', function() {
            it('throw cloak\writer\DirectoryNotFoundException', function() {
                expect(function() {
                    new FileWriter($this->directory->resolvePath('tmp/file.txt'));
                })->toThrow(DirectoryNotFoundException::class);
            });
        });
        context('when directory not writable', function() {
            beforeEach(function() {
                $this->directory->chmod(0444);
                $this->outputFilePath = $this->directory->resolvePath('file.txt');
            });
            it('throw cloak\writer\DirectoryNotWritableException', function() {
                expect(function() {
                    new FileWriter($this->outputFilePath);
                })->toThrow(DirectoryNotWritableException::class);
            });
        });
    });

    describe('#writeText', function() {
        beforeEach(function() {
            $directory = $this->makeDirectory();
            $reportFile = $directory->resolvePath('report.txt');

            $this->text = 'text';

            $writer = new FileWriter($reportFile);
            $writer->writeText($this->text);

            $this->size = $writer->getWriteSize();
        });
        it('write text', function() {
            expect($this->size)->toEqual(strlen($this->text));
        });
    });

    describe('#writeLine', function() {
        beforeEach(function() {
            $directory = $this->makeDirectory();
            $reportFile = $directory->resolvePath('report.txt');

            $this->text = 'text';
            $writer = new FileWriter($reportFile);
            $writer->writeLine($this->text);

            $this->size = $writer->getWriteSize();
        });
        it('write text', function() {
            expect($this->size)->toEqual(strlen($this->text) + 1);
        });
    });

    describe('#writeEOL', function() {
        beforeEach(function() {
            $directory = $this->makeDirectory();
            $reportFile = $directory->resolvePath('report.txt');

            $writer = new FileWriter($reportFile);
            $writer->writeEOL();

            $this->content = file_get_contents($reportFile);
        });
        it('write empty line', function() {
            expect($this->content)->toEqual(PHP_EOL);
        });
    });

});
