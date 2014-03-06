<?php

use CodeAnalyzer\Result\File;
use CodeAnalyzer\Result\Line;
use PhpCollection\Sequence;

describe('File', function() {

    describe('#getLines', function() {
        before(function() {
            $this->file = new File('foo.php');
        });
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
        before(function() {
            $this->file = new File('foo.php');
        });
        it('should return CodeAnalyzer\Result\File instance', function() {
            expect($this->file->setLines(new Sequence()))->toBeAnInstanceOf('CodeAnalyzer\Result\File');
        });
    });

    describe('#equals', function() {
        context('when path equals', function() {
            before(function() {
                $this->file1 = new File('foo.php');
                $this->file2 = new File('foo.php');
            });
            it('should return true', function() {
                $result = $this->file1->equals($this->file2);
                expect($result)->toBeTrue();
            });
        });
    });

    describe('#matchPath', function() {
        before(function() {
            $this->file = new File('foo.php');
        });
        context('when included in the path', function() {
            it('should return true', function() {
                $result = $this->file->matchPath('foo');
                expect($result)->toBeTrue();
            });
        });
        context('when not included in the path', function() {
            it('should return false', function() {
                $result = $this->file->matchPath('bar');
                expect($result)->toBeFalse();
            });
        });
    });

    describe('#addLine', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->line = new Line(2, Line::EXECUTED);
        });
        it('should add line', function() {
            $this->file->addLine($this->line);
            expect($this->file->getLines()->last()->get())->toEqual($this->line);
        });
    });

    describe('#removeLine', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->line = new Line(2, Line::EXECUTED);
        });
        it('should remove line', function() {
            $this->file->addLine($this->line);
            $this->file->removeLine($this->line);
            expect($this->file->getLines()->count())->toBe(0);
        });
    });

    describe('#getDeadLineCount', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->deadLine = new Line(1, Line::DEAD);
            $this->executedLine = new Line(2, Line::EXECUTED);
            $this->file->addLine($this->deadLine);
            $this->file->addLine($this->executedLine);
        });
        it('should return total number of lines is dead', function() {
            expect($this->file->getDeadLineCount())->toBe(1);
        });
    });

    describe('#getUnusedLineCount', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->deadLine = new Line(1, Line::DEAD);
            $this->executedLine = new Line(2, Line::UNUSED);
            $this->file->addLine($this->deadLine);
            $this->file->addLine($this->executedLine);
        });
        it('should return total number of lines is unused', function() {
            expect($this->file->getUnusedLineCount())->toBe(1);
        });
    });

    describe('#getExecutedLineCount', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->deadLine = new Line(1, Line::DEAD);
            $this->executedLine = new Line(2, Line::EXECUTED);
            $this->file->addLine($this->deadLine);
            $this->file->addLine($this->executedLine);
        });
        it('should return total number of lines is executed', function() {
            expect($this->file->getExecutedLineCount())->toBe(1);
        });
    });

    describe('#getCodeCoverage', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->file->addLine( new Line(1, Line::UNUSED) );
            $this->file->addLine( new Line(1, Line::EXECUTED) );
        });
        it('should return The value of code coverage', function() {
            expect($this->file->getCodeCoverage())->toBe(50.00);
        });
    });

});
