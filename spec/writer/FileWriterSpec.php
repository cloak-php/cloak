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

    before(function() {
        $this->directory = __DIR__ . '/../tmp/';
        $this->filePath = $this->directory . 'output.txt';
    });

    describe('#writeText', function() {
        before(function() {
            $this->text = 'text';

            unlink($this->filePath);

            $this->writer = new FileWriter($this->filePath);
            $this->writer->writeText($this->text);

            $this->size = $this->writer->getWriteSize();
        });
        after(function() {
            unlink($this->filePath);
        });
        it('write text', function() {
            expect($this->size)->toBe(strlen($this->text));
        });
    });

    describe('#writeLine', function() {
        before(function() {
            $this->text = 'text';

            $this->writer = new FileWriter($this->filePath);
            $this->writer->writeLine($this->text);

            $this->size = $this->writer->getWriteSize();
        });
        after(function() {
            unlink($this->filePath);
        });
        it('write text', function() {
            expect($this->size)->toBe(strlen($this->text) + 1);
        });
    });

});
