<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Result;
use cloak\writer\ConsoleWriter;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Console;

describe('ConsoleWriter', function() {

    describe('#writeText', function() {
        before(function() {
            $this->writer = new ConsoleWriter();
            $this->console = Console::getInstance();
        });
        context('with text', function() {
            before(function() {
                $this->text = 'text';
                $this->output = $this->text;
            });
            it('print text', function() {
                expect(function() {
                    $this->writer->writeText($this->text);
                })->toPrint($this->output);
            });
        });
        context('with text and color', function() {
            before(function() {
                $this->text = 'text';
                $this->output = $this->console->colorize($this->text, Color::CYAN);
            });
            it('print with color', function() {
                expect(function() {
                    $this->writer->writeText($this->text, Color::CYAN);
                })->toPrint($this->output);
            });
        });
    });

    describe('#writeLine', function() {
        before(function() {
            $this->writer = new ConsoleWriter();
        });
        context('with text', function() {
            before(function() {
                $this->text = 'text';
                $this->output = 'text' . PHP_EOL;
            });
            it('print text', function() {
                expect(function() {
                    $this->writer->writeLine($this->text);
                })->toPrint($this->output);
            });
        });
        context('with text and color', function() {
            before(function() {
                $this->console = Console::getInstance();

                $this->text = 'text';

                $colorizeText = $this->console->colorize($this->text, Color::CYAN);
                $this->output = $colorizeText . PHP_EOL;
            });
            it('print with color', function() {
                expect(function() {
                    $this->writer->writeLine($this->text, Color::CYAN);
                })->toPrint($this->output);
            });
        });
    });

});
