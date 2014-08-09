<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\File;
use cloak\result\Line;
use cloak\value\Coverage;
use PhpCollection\Sequence;

describe('File', function() {

    describe('#getRelativePath', function() {
        $this->file = new File(__FILE__);

        it('should return relative path', function() {
            expect($this->file->getRelativePath(__DIR__))->toEqual('FileSpec.php');
        });
    });

    describe('#getLines', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');

        context('when line is empty', function() {
            it('should return PhpCollection\Sequence instance', function() {
                expect($this->file->getLines())->toBeAnInstanceOf('PhpCollection\Sequence');
            });
        });
        context('when there is a line', function() {
            it('should return PhpCollection\Sequence instance', function() {
                $this->file->addLine(new Line('foo.php'));
                expect($this->file->getLines())->toBeAnInstanceOf('PhpCollection\Sequence');
                expect($this->file->getLines()->count())->toBe(1);
            });
        });
    });

    describe('#setLines', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');

        it('should return cloak\result\File instance', function() {
            expect($this->file->setLines(new Sequence()))->toBeAnInstanceOf('cloak\result\File');
        });
    });

    describe('#equals', function() {
        context('when path equals', function() {
            $this->file1 = new File(__DIR__ . '/../fixtures/src/foo.php');
            $this->file2 = new File(__DIR__ . '/../fixtures/src/foo.php');

            it('should return true', function() {
                $result = $this->file1->equals($this->file2);
                expect($result)->toBeTrue();
            });
        });
    });

    describe('#matchPath', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');

        context('when included in the path', function() {
            it('should return true', function() {
                $result = $this->file->matchPath('/foo');
                expect($result)->toBeTrue();
            });
        });
        context('when not included in the path', function() {
            it('should return false', function() {
                $result = $this->file->matchPath('/bar');
                expect($result)->toBeFalse();
            });
        });
    });

    describe('#addLine', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
        $this->line = new Line(2, Line::EXECUTED);

        it('should add line', function() {
            $this->file->addLine($this->line);
            expect($this->file->getLines()->last()->get())->toEqual($this->line);
        });
    });

    describe('#removeLine', function() {
        context('when specify a line that exists', function() {
            before(function() {
                $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
                $this->line = new Line(2, Line::EXECUTED);
                $this->file->addLine($this->line);
                $this->file->removeLine($this->line);
            });
            it('should remove line', function() {
                expect($this->file->getLines()->count())->toBe(0);
            });
        });
        context('when specify a line that not exists', function() {
            before(function() {
                $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
                $this->line = new Line(2, Line::EXECUTED);
            });
            it('throw \UnexpectedValueException', function() {
                expect(function() {
                    $this->file->removeLine($this->line);
                })->toThrow('\UnexpectedValueException');
            });
        });
    });

    describe('#getDeadLineCount', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
        $this->deadLine = new Line(1, Line::DEAD);
        $this->executedLine = new Line(2, Line::EXECUTED);

        before(function() {
            $this->file->addLine($this->deadLine);
            $this->file->addLine($this->executedLine);
        });
        it('should return total number of lines is dead', function() {
            expect($this->file->getDeadLineCount())->toBe(1);
        });
    });

    describe('#getUnusedLineCount', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
        $this->deadLine = new Line(1, Line::DEAD);
        $this->executedLine = new Line(2, Line::UNUSED);

        before(function() {
            $this->file->addLine($this->deadLine);
            $this->file->addLine($this->executedLine);
        });
        it('should return total number of lines is unused', function() {
            expect($this->file->getUnusedLineCount())->toBe(1);
        });
    });

    describe('#getExecutedLineCount', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
        $this->deadLine = new Line(1, Line::DEAD);
        $this->executedLine = new Line(2, Line::EXECUTED);

        before(function() {
            $this->file->addLine($this->deadLine);
            $this->file->addLine($this->executedLine);
        });
        it('should return total number of lines is executed', function() {
            expect($this->file->getExecutedLineCount())->toBe(1);
        });
    });

    describe('#getCodeCoverage', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');

        before(function() {
            $this->file->addLine( new Line(1, Line::UNUSED) );
            $this->file->addLine( new Line(1, Line::EXECUTED) );
        });
        it('should return the value of code coverage', function() {
            expect($this->file->getCodeCoverage()->valueOf())->toBe(50.00);
        });
    });

    describe('#isCoverageLessThan', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');

        before(function() {
            $this->file->addLine( new Line(1, Line::UNUSED) );
            $this->file->addLine( new Line(1, Line::EXECUTED) );
        });
        context('when less than 51% of coverage', function() {
            it('should return true', function() {
                $coverage = new Coverage(51);
                expect($this->file->isCoverageLessThan($coverage))->toBeTrue();
            });
        });
        context('when greater than 50% of coverage', function() {
            it('should return false', function() {
                $coverage = new Coverage(50);
                expect($this->file->isCoverageLessThan($coverage))->toBeFalse();
            });
        });
    });

    describe('#isCoverageGreaterEqual', function() {
        $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');

        before(function() {
            $this->file->addLine( new Line(1, Line::UNUSED) );
            $this->file->addLine( new Line(1, Line::EXECUTED) );
        });

        context('when less than 51% of coverage', function() {
            it('should return false', function() {
                $coverage = new Coverage(51);
                expect($this->file->isCoverageGreaterEqual($coverage))->toBeFalse();
            });
        });
        context('when greater than 50% of coverage', function() {
            it('should return true', function() {
                $coverage = new Coverage(50);
                expect($this->file->isCoverageGreaterEqual($coverage))->toBeTrue();
            });
        });
    });

});
