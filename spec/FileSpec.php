<?php

use CodeAnalyzer\File;
use CodeAnalyzer\Line;
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
        it('should return CodeAnalyzer\File instance', function() {
            expect($this->file->setLines(new Sequence()))->toBeAnInstanceOf('CodeAnalyzer\File');
        });
    });

    describe('#equals', function() {
        before(function() {
            $this->file1 = new File('foo.php');
            $this->file2 = new File('foo.php');
        });
        it('', function() {
            $result = $this->file1->equals($this->file2);
            expect($result)->toBeTrue();
        });
    });

    describe('#addLine', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->line = new Line(2, Line::EXECUTED);
        });
        it('', function() {
            $this->file->addLine($this->line);
            expect($this->file->getLines()->last()->get())->toEqual($this->line);
        });
    });

    describe('#removeLine', function() {
        before(function() {
            $this->file = new File('foo.php');
            $this->line = new Line(2, Line::EXECUTED);
        });
        it('', function() {
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
        it('', function() {
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
        it('', function() {
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
        it('', function() {
            expect($this->file->getExecutedLineCount())->toBe(1);
        });
    });

});
