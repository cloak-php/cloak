<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\result\File;

describe('File', function() {
    describe('#matchPath', function() {
        before(function() {
            $rootDirectory = __DIR__ . '/../../fixtures/src/';

            $filePath = $rootDirectory . 'foo.php';
            $this->file = new File($filePath);
        });
        context('when match', function() {
            it('return true', function() {
                expect($this->file->matchPath('/fixtures'))->toBeTrue();
            });
        });
        context('when unmatch', function() {
            it('return false', function() {
                expect($this->file->matchPath('/bar'))->toBeFalse();
            });
        });
    });
});
