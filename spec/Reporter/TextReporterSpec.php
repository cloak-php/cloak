<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Analyzer,
    CodeAnalyzer\Configuration,
    CodeAnalyzer\Event,
    CodeAnalyzer\Result,
    CodeAnalyzer\Result\Line,
    CodeAnalyzer\Reporter\TextReporter,
    Colors\Color;

describe('TextReporter', function() {

    describe('onStop', function() {
        $coverages = [
            realpath(__DIR__ . '/../../src/Driver/XdebugDriver.php') => [
                1 => Line::EXECUTED,
                2 => Line::EXECUTED,
                3 => Line::UNUSED
            ],
            realpath(__DIR__ . '/../../src/Result/Line.php') => [
                1 => Line::EXECUTED,
                2 => Line::EXECUTED,
                3 => Line::EXECUTED,
                4 => Line::EXECUTED,
                5 => Line::EXECUTED,
                6 => Line::EXECUTED,
                7 => Line::EXECUTED,
                8 => Line::UNUSED,
                9 => Line::UNUSED,
               10 => Line::UNUSED
            ],
            realpath(__DIR__ . '/../../src/Result/File.php') => [
                1 => Line::EXECUTED,
                2 => Line::EXECUTED,
                3 => Line::UNUSED,
                4 => Line::UNUSED,
                5 => Line::UNUSED,
                6 => Line::UNUSED,
                7 => Line::UNUSED
            ]
        ];

        $this->result = Result::from($coverages);

        $this->target = new Analyzer(new Configuration());
        $this->event = new Event('stop', $this->target, array(
            'result' => $this->result
        ));

        $this->high = new Color(sprintf('%6.2f%%', (float) 70));
        $this->low = new Color(sprintf('%6.2f%%', (float) 28.57));
        $this->normal = new Color(sprintf('%6.2f%%', (float) 66.67));

        $this->reporter = new TextReporter();

        before(function() {
            $this->high->setForceStyle(true);
            $this->high->green();

            $this->low->setForceStyle(true);
            $this->low->yellow();

            $this->normal->setForceStyle(true);
        });
        it('should output coverage', function() {
            $output  = "";
            $output .= "src/Driver/XdebugDriver.php .......................................... " . $this->normal . " ( 2/ 3)" . PHP_EOL;
            $output .= 'src/Result/Line.php .................................................. ' . $this->high . ' ( 7/10)' . PHP_EOL;
            $output .= "src/Result/File.php .................................................. " . $this->low . " ( 2/ 7)" . PHP_EOL;

            expect(function() {
                $this->reporter->onStop($this->event);
            })->toPrint($output);
        });
    });

});
