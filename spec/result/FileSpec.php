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

describe('File', function() {

    describe('#getRelativePath', function() {
        before(function() {
            $this->file = new File(__FILE__);
        });
        it('should return relative path', function() {
            expect($this->file->getRelativePath(__DIR__))->toEqual('FileSpec.php');
        });
    });

    describe('#getLines', function() {
        context('when line is empty', function() {
            before(function() {
                $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
            });
            it('should return cloak\result\LineSet instance', function() {
                expect($this->file->getLines())->toBeAnInstanceOf('cloak\result\LineSet');
            });
        });
        context('when line is not empty', function() {
            before(function() {
                $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                    12 => Line::EXECUTED,
                    17 => Line::UNUSED
                ]);
            });
            it('should return cloak\result\LineSet instance', function() {
                expect($this->file->getLines())->toBeAnInstanceOf('cloak\result\LineSet');
            });
            it('should return cloak\result\LineSet instance', function() {
                expect($this->file->getLines()->getLineCount())->toBe(2);
            });
        });
    });

    describe('#equals', function() {
        context('when path equals', function() {
            before(function() {
                $this->file1 = new File(__DIR__ . '/../fixtures/src/foo.php');
                $this->file2 = new File(__DIR__ . '/../fixtures/src/foo.php');
            });
            it('should return true', function() {
                $result = $this->file1->equals($this->file2);
                expect($result)->toBeTrue();
            });
        });
    });

    describe('#matchPath', function() {
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php');
        });
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

    describe('#getDeadLineCount', function() {
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                12 => Line::DEAD,
                17 => Line::EXECUTED
            ]);
        });
        it('should return total number of lines is dead', function() {
            expect($this->file->getDeadLineCount())->toBe(1);
        });
    });

    describe('#getUnusedLineCount', function() {
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                1 => Line::DEAD,
                2 => Line::UNUSED
            ]);
        });
        it('should return total number of lines is unused', function() {
            expect($this->file->getUnusedLineCount())->toBe(1);
        });
    });

    describe('#getExecutedLineCount', function() {
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                1 => Line::DEAD,
                2 => Line::EXECUTED
            ]);
        });
        it('should return total number of lines is executed', function() {
            expect($this->file->getExecutedLineCount())->toBe(1);
        });
    });

    describe('#getCodeCoverage', function() {
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                12 => Line::EXECUTED,
                17 => Line::UNUSED
            ]);
        });
        it('should return the value of code coverage', function() {
            expect($this->file->getCodeCoverage()->valueOf())->toBe(50.00);
        });
    });

    describe('#isCoverageLessThan', function() {
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                12 => Line::EXECUTED,
                17 => Line::UNUSED
            ]);
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
        before(function() {
            $this->file = new File(__DIR__ . '/../fixtures/src/foo.php', [
                12 => Line::EXECUTED,
                17 => Line::UNUSED
            ]);
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
