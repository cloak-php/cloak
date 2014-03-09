<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\ConfigurationBuilder;
use CodeAnalyzer\Result\Line;
use CodeAnalyzer\Result\File;
use CodeAnalyzer\Driver\DriverInterface;
use Mockery as Mock;


describe('Analyzer', function() {

    $subject = $this->subject = new \stdClass();
    $subject->called = 0;
    $subject->configuration = null;

    $this->builder = function(ConfigurationBuilder $builder) use ($subject) {
        $subject->called++;
        $subject->builder = $builder;
    };

    describe('#configure', function() {
        before(function() {
            Analyzer::configure($this->builder);
        });
        it('should called once', function() {
            expect($this->subject->called)->toBe(1);
        });
        it('should argument is an instance of CodeAnalyzer\ConfigurationBuilder', function() {
            expect($this->subject->builder)->toBeAnInstanceOf('CodeAnalyzer\ConfigurationBuilder');
        });
    });

    describe('#factory', function() {
        before(function() {
            $subject = $this->subject = new \stdClass();
            $subject->called = 0;
            $subject->configuration = null;

            $this->builder = function(ConfigurationBuilder $builder) use ($subject) {
                $subject->called++;
                $subject->builder = $builder;
            };
            $this->returnValue = Analyzer::factory($this->builder);
        });
        it('should called once', function() {
            expect($this->subject->called)->toBe(1);
        });
        it('should argument is an instance of CodeAnalyzer\ConfigurationBuilder', function() {
            expect($this->subject->builder)->toBeAnInstanceOf('CodeAnalyzer\ConfigurationBuilder');
        });
        it('should return an instance of CodeAnalyzer\Analyzer', function() {
            expect($this->returnValue)->toBeAnInstanceOf('CodeAnalyzer\Analyzer');
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            before(function() {
                $this->driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $this->driver->shouldReceive('start')->once();
                $this->driver->shouldReceive('isStarted')->once()->andReturn(true);
                $this->analyzer = new Analyzer($this->driver);
            });
            after(function() {
                Mock::close();
            });
            it('should return true', function() {
                $this->analyzer->start();
                expect($this->analyzer->isStarted())->toBeTrue();
            });
        });
        context('when stoped', function() {
            before(function() {
                $this->driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $this->driver->shouldReceive('start')->once();
                $this->driver->shouldReceive('stop')->once();
                $this->driver->shouldReceive('getResult')->once()->andReturn(array(
                    'foo.php' => array( 1 => Line::EXECUTED )
                ));
                $this->driver->shouldReceive('isStarted')->once()->andReturn(false);
                $this->analyzer = new Analyzer($this->driver);
                $this->analyzer->start();
            });
            after(function() {
                Mock::close();
            });
            it('should return false', function() {
                $this->analyzer->stop();
                expect($this->analyzer->isStarted())->toBeFalse();
            });
        });
    });

    describe('#getResult', function() {
        before(function() {
            $this->driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
            $this->driver->shouldReceive('start')->once();
            $this->driver->shouldReceive('stop')->once();
            $this->driver->shouldReceive('getResult')->once()->andReturn(array(
                'src/foo.php' => array( 1 => Line::EXECUTED ),
                'src/bar.php' => array( 1 => Line::EXECUTED ),
                'src/vendor/foo1.php' => array( 1 => Line::EXECUTED ),
                'src/vendor/foo2.php' => array( 1 => Line::EXECUTED )
            ));
            Analyzer::configure(function(ConfigurationBuilder $builder) {
                $builder->includeFile(function(File $file) {
                    return $file->matchPath('src');
                })->excludeFile(function(File $file) {
                    return $file->matchPath('vendor');
                });
            });
            $this->analyzer = new Analyzer($this->driver);
            $this->analyzer->start();
            $this->analyzer->stop();
            $this->result = $this->analyzer->getResult();
        });
        after(function() {
            Mock::close();
        });
        it('should return an instance of CodeAnalyzer\Result', function() {
            $files = $this->result->getFiles();

            expect($files->count())->toBe(2);
            expect($this->result)->toBeAnInstanceOf('CodeAnalyzer\Result');
        });
    });

});
