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
    CodeAnalyzer\ConfigurationBuilder,
    CodeAnalyzer\Result,
    CodeAnalyzer\Result\Line,
    CodeAnalyzer\Result\File,
    CodeAnalyzer\Driver\DriverInterface,
    CodeAnalyzer\Reporter\ReporterInterface,
    Mockery as Mock;

describe('Analyzer', function() {

    $subject = $this->subject = new \stdClass();
    $subject->called = 0;
    $subject->configuration = null;

    $this->builder = function(ConfigurationBuilder $builder) use ($subject) {
        $subject->called++;
        $subject->builder = $builder;
    };

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

    describe('#stop', function() {
        before(function() {
            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                $driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('stop')->once();
                $driver->shouldReceive('getResult')->once()->andReturn(array(
                    'foo.php' => array( 1 => Line::EXECUTED )
                ));
                $builder->driver($driver);
            });

            $subject = $this->subject = new \stdClass();
            $this->notifier = Mock::mock('CodeAnalyzer\NotifierInterface');
            $this->notifier->shouldReceive('stop')->once()->with(Mock::on(function($result) use ($subject) {
                $subject->result = $result;
                return true;
            }));

            $this->analyzer->setNotifier($this->notifier);

            $this->analyzer->start();
            $this->analyzer->stop();
        });
        after(function() {
            Mock::close();
        });
        it('should return CodeAnalyzer\Result instance', function() {
            expect($this->subject->result)->toBeAnInstanceOf('CodeAnalyzer\Result');
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            before(function() {
                $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                    $driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                    $driver->shouldReceive('start')->once();
                    $driver->shouldReceive('isStarted')->once()->andReturn(true);
                    $builder->driver($driver);
                });
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
                $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                    $driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                    $driver->shouldReceive('start')->once();
                    $driver->shouldReceive('stop')->once();
                    $driver->shouldReceive('isStarted')->once()->andReturn(false);
                    $builder->driver($driver);
                });
                $this->analyzer->start();
                $this->analyzer->stop();
            });
            after(function() {
                Mock::close();
            });
            it('should return false', function() {
                expect($this->analyzer->isStarted())->toBeFalse();
            });
        });
    });

    describe('#getResult', function() {
        before(function() {
            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) use ($reporter) {
                $rootDirectory = __DIR__ . '/fixtures/src/';

                $coverageResults = [
                    $rootDirectory . 'foo.php' => array( 1 => Line::EXECUTED ),
                    $rootDirectory . 'bar.php' => array( 1 => Line::EXECUTED ),
                    $rootDirectory . 'vendor/foo1.php' => array( 1 => Line::EXECUTED ),
                    $rootDirectory . 'vendor/foo2.php' => array( 1 => Line::EXECUTED )
                ];

                $driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('stop')->once();
                $driver->shouldReceive('getResult')->once()->andReturn($coverageResults);

                $builder->driver($driver)
                    ->includeFile(function(File $file) {
                        return $file->matchPath('src');
                    })->excludeFile(function(File $file) {
                        return $file->matchPath('vendor');
                    });

                $builder->reporter($reporter);
            });

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
