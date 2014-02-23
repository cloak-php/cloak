<?php

use CodeAnalyzer\File;
use CodeAnalyzer\Line;

describe('File', function() {

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

});
