<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\Result;
use cloak\driver\result\File;

describe('Result', function() {
    describe('#add', function() {
        before(function() {
            $rootDirectory = __DIR__ . '/../../fixtures/src/';
            $this->filePath = $rootDirectory . 'foo.php';

            $this->result = new Result();
            $this->result->add(new File($this->filePath));
        });
        it('add file', function() {
            expect(count($this->result))->toEqual(1);
        });
    });
});
