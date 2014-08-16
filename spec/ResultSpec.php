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
use cloak\value\Coverage;
use cloak\result\Line;
use cloak\result\File;
use cloak\result\LineSet;
use PhpCollection\Sequence;


describe('Result', function() {

    $this->rootDirectory = __DIR__ . '/fixtures/src/';
    $this->returnValue = null;

    describe('#from', function() {
        $coverageResults = [
            $this->rootDirectory . 'foo.php' => [ 1 => Line::EXECUTED ]
        ];
        $this->returnValue = Result::from($coverageResults);

        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Result');
        });
    });

    describe('#parseResult', function() {
        $coverageResults = [
            $this->rootDirectory . 'foo.php' => [ 1 => Line::EXECUTED ],
            $this->rootDirectory . 'not_found.php' => [ 1 => Line::EXECUTED ]
        ];

        $this->returnValue = Result::parseResult($coverageResults);

        it('should return PhpCollection\Sequence instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('PhpCollection\Sequence');
        });

        context('when a file that does not exist is included', function() {
            it('should not included in the result', function() {
                expect($this->returnValue->count())->toBe(1);
            });
        });
    });

    describe('#includeFile', function() {
        $coverageResults = [
            $this->rootDirectory . 'foo.php' => [
                1 => Line::EXECUTED,
                2 => Line::UNUSED,
                3 => Line::DEAD
            ],
            $this->rootDirectory . 'bar.php' => [
                1 => Line::EXECUTED,
                2 => Line::UNUSED,
                3 => Line::DEAD
            ]
        ];

        $this->result = Result::from($coverageResults);
        $this->returnValue = $this->result->includeFile(function(File $file) {
            return $file->matchPath('bar.php');
        });

        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Result');
        });
        it('should include only those that match element', function() {
            $files = $this->returnValue->getFiles();
            expect($files->count())->toBe(1);
            expect($files->last()->get()->matchPath('bar.php'))->toBeTrue();
        });
    });

    describe('#includeFiles', function() {
        $coverageResults = [
            $this->rootDirectory . 'foo1.php' => [ 1 => Line::EXECUTED ],
            $this->rootDirectory . 'vendor/foo1.php' => [ 1 => Line::EXECUTED ],
            $this->rootDirectory . 'bar.php' => [ 1 => Line::EXECUTED ]
        ];

        $this->result = Result::from($coverageResults);
        $filter1 = function(File $file) {
            return $file->matchPath('foo1.php');
        };
        $filter2 = function(File $file) {
            return $file->matchPath('/vendor');
        };
        $this->returnValue = $this->result->includeFiles(array($filter1, $filter2));

        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Result');
        });
        it('should include only those that match element', function() {
            $files = $this->returnValue->getFiles();
            expect($files->count())->toBe(1);
        });
    });

    describe('#excludeFile', function() {
        $coverageResults = [
            $this->rootDirectory . 'foo.php' => [ 1 => Line::EXECUTED ],
            $this->rootDirectory . 'bar.php' => [ 1 => Line::EXECUTED ]
        ];

        $this->result = Result::from($coverageResults);

        $this->returnValue = $this->result->excludeFile(function(File $file) {
            return $file->matchPath('foo.php');
        });

        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Result');
        });
        it('should exclude only those that match element', function() {
            $files = $this->returnValue->getFiles();
            expect($files->count())->toBe(1);
            expect($files->last()->get()->matchPath('bar.php'))->toBeTrue();
        });
    });

    describe('#excludeFiles', function() {
        $coverageResults = [
            $this->rootDirectory . 'foo.php' => [ 1 => Line::EXECUTED ],
            $this->rootDirectory . 'bar.php' => [ 1 => Line::EXECUTED ]
        ];

        $this->result = Result::from($coverageResults);

            $filter1 = function(File $file) {
                return $file->matchPath('foo.php');
            };
            $filter2 = function(File $file) {
                return $file->matchPath('bar.php');
            };
            $this->returnValue = $this->result->excludeFiles(array($filter1, $filter2));

        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Result');
        });
        it('should exclude only those that match element', function() {
            $files = $this->returnValue->getFiles();
            expect($files->count())->toBe(0);
        });
    });

    describe('#setFiles', function() {
        $this->files = new Sequence();
        $this->result = new Result();
        $this->returnValue = $this->result->setFiles($this->files);

        it('should should the files is replaced', function() {
            expect($this->result->getFiles())->toEqual($this->files);
        });
        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toEqual($this->result);
        });
    });

    describe('#addFile', function() {
        $file = $this->rootDirectory . 'foo.php';

        $this->result = new Result();
        $this->file = new File($file, new LineSet);
        $this->returnValue = $this->result->addFile($this->file);

        it('should add file', function() {
            $files = $this->returnValue->getFiles();
            expect($files->last()->get()->getPath())->toEqual($this->file->getPath());
        });
        it('should return cloak\Result instance', function() {
            expect($this->returnValue)->toEqual($this->result);
        });
    });

    describe('#removeFile', function() {
        context('when specify a file that exists', function() {
            before(function() {
                $file = $this->rootDirectory . 'foo.php';

                $this->result = new Result();
                $this->file = new File($file, new LineSet);
                $this->result->addFile($this->file);
                $this->returnValue = $this->result->removeFile($this->file);
            });
            it('should remove file', function() {
                $files = $this->returnValue->getFiles();
                expect($files->count())->toBe(0);
            });
            it('should return cloak\Result instance', function() {
                expect($this->returnValue)->toEqual($this->result);
            });
        });
        context('when specify a file that not exists', function() {
            before(function() {
                $file = $this->rootDirectory . 'foo.php';
                $this->file = new File($file, new LineSet());

                $this->result = new Result();
            });
            it('throw \UnexpectedValueException', function() {
                expect(function() {
                    $this->result->removeFile($this->file);
                })->toThrow('\UnexpectedValueException');
            });
        });
    });

    describe('summary', function() {
        before(function() {
            $filePath1 = $this->rootDirectory . 'foo.php';
            $filePath2 = $this->rootDirectory . 'bar.php';
            $file1 = new File($filePath1, new LineSet([
                new Line(10, Line::DEAD),
                new Line(12, Line::EXECUTED),
                new Line(17, Line::UNUSED)
            ]));
            $file2 = new File($filePath2, new LineSet([
                new Line(1, Line::UNUSED)
            ]));

            $this->result = new Result();
            $this->result->addFile($file1);
            $this->result->addFile($file2);
        });

        describe('#getLineCount', function() {
            it('return total line count', function() {
                expect($this->result->getLineCount())->toEqual(21);
            });
        });

        describe('#getDeadLineCount', function() {
            it('return total dead line count', function() {
                expect($this->result->getDeadLineCount())->toEqual(1);
            });
        });

        describe('#getExecutedLineCount', function() {
            it('return total executed line count', function() {
                expect($this->result->getExecutedLineCount())->toEqual(1);
            });
        });

        describe('#getExecutableLineCount', function() {
            it('return total executable line count', function() {
                expect($this->result->getExecutableLineCount())->toEqual(3);
            });
        });

        describe('#getCodeCoverage', function() {
            it('return total code coverage', function() {
                expect($this->result->getCodeCoverage()->value())->toEqual(33.33);
            });
        });

        describe('#isCoverageLessThan', function() {
            context('when less than', function() {
                before(function() {
                    $this->coverage = new Coverage(34.0);
                    $this->result = $this->result->isCoverageLessThan($this->coverage);
                });
                it('return true', function () {
                    expect($this->result)->toBeTrue();
                });
            });
        });

        describe('#isCoverageGreaterEqual', function() {
            context('when greater equal', function() {
                before(function() {
                    $this->coverage = new Coverage(33.33);
                    $this->result = $this->result->isCoverageGreaterEqual($this->coverage);
                });
                it('return true', function () {
                    expect($this->result)->toBeTrue();
                });
            });
        });
    });

});
