<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Result;
use CodeAnalyzer\Result\Line;
use CodeAnalyzer\Reporter\TextReporter;

describe('TextReporter', function() {

    describe('stop', function() {
        before(function() {
            $this->result = Result::from(array(
                '/Users/shared-hat/Documents/develop/code-analyzer/src/Driver/XdebugDriver.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::EXECUTED,
                    3 => Line::UNUSED
                ),
                '/Users/shared-hat/Documents/develop/code-analyzer/src/Result/File.php' => array(
                    1 => Line::EXECUTED,
                    2 => Line::EXECUTED,
                    3 => Line::UNUSED
                )
            ));
            $this->reporter = new TextReporter();
        });
        it('should output coverage', function() {
            $output  = "";
            $output .= "src/Driver/XdebugDriver.php > 66.67% (2/3)" . PHP_EOL;
            $output .= "src/Result/File.php > 66.67% (2/3)" . PHP_EOL;

            expect(function() {
                $this->reporter->stop($this->result);
            })->toPrint($output);
        });
    });

});
