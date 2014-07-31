<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\report\TextReport;

describe('TextReport', function() {

    describe('#output', function() {
        before(function() {
            $this->report = new TextReport('report');
        });
        it('print a report', function() {
            expect(function() {
                $this->report->output();
            })->toPrint('report');
        });
    });

});
