<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Analyzer;
use cloak\configuration\ConfigurationBuilder;
use cloak\Result;
use cloak\driver\Result as AnalyzeResult;
use cloak\result\LineResult;
use cloak\result\FileResult;
use \Mockery;


describe('Analyzer', function() {
    beforeEach(function() {
        $subject = $this->subject = new \stdClass();
        $subject->called = 0;
        $subject->configuration = null;

        $this->builder = function(ConfigurationBuilder $builder) use ($subject) {
            $subject->called++;
            $subject->builder = $builder;
        };
    });

    describe('#factory', function() {
        beforeEach(function() {
            $this->verify = function() {
                Mockery::close();
            };
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
            expect($this->subject->called)->toEqual(1);
        });
        it('should argument is an instance of cloak\configuration\ConfigurationBuilder', function() {
            expect($this->subject->builder)->toBeAnInstanceOf('cloak\configuration\ConfigurationBuilder');
        });
        it('should return an instance of cloak\Analyzer', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Analyzer');
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

    describe('#stop', function() {
        beforeEach(function() {

            $this->verify = function() {
                Mockery::close();
            };

            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

                $rootDirectory = __DIR__ . '/fixtures/src/';

                $analyzeResult = AnalyzeResult::fromArray([
                    $rootDirectory . 'foo.php' => [
                        1 => LineResult::EXECUTED
                    ]
                ]);

                $driver = Mockery::mock('cloak\Driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('stop')->once();
                $driver->shouldReceive('getAnalyzeResult')
                    ->once()->andReturn($analyzeResult);

                $builder->driver($driver);
            });

            $subject = $this->subject = new \stdClass();

            $this->notifier = Mockery::mock('cloak\AnalyzeLifeCycleNotifierInterface');
            $this->notifier->shouldReceive('notifyStart')->once();
            $this->notifier->shouldReceive('notifyStop')->once()->with(Mockery::on(function($result) use ($subject) {
                $subject->result = $result;
                return true;
            }));

            $this->analyzer->setLifeCycleNotifier($this->notifier);
            $this->analyzer->start();
            $this->analyzer->stop();
        });
        it('should return cloak\Result instance', function() {
            expect($this->subject->result)->toBeAnInstanceOf('cloak\Result');
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            beforeEach(function() {
                $this->verify = function() {
                    Mockery::close();
                };
                $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                    $driver = Mockery::mock('cloak\driver\DriverInterface');
                    $driver->shouldReceive('start')->once();
                    $driver->shouldReceive('isStarted')->once()->andReturn(true);
                    $builder->driver($driver);
                });
                $this->analyzer->start();

                $this->started = $this->analyzer->isStarted();
            });
            it('should return true', function() {
                expect($this->started)->toBeTrue();
            });
            it('check mock object expectations', function() {
                call_user_func($this->verify);
            });
        });
        context('when stoped', function() {
            beforeEach(function() {
                $this->verify = function() {
                    Mockery::close();
                };

                $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

                    $rootDirectory = __DIR__ . '/fixtures/src/';

                    $analyzeResult = AnalyzeResult::fromArray([
                        $rootDirectory . 'foo.php' => [
                            1 => LineResult::EXECUTED
                        ]
                    ]);

                    $driver = Mockery::mock('cloak\driver\DriverInterface');
                    $driver->shouldReceive('start')->once();
                    $driver->shouldReceive('stop')->once();
                    $driver->shouldReceive('isStarted')->once()->andReturn(false);
                    $driver->shouldReceive('getAnalyzeResult')->once()->andReturn($analyzeResult);

                    $builder->driver($driver);
                });

                $this->analyzer->start();
                $this->analyzer->stop();

                $this->started = $this->analyzer->isStarted();
            });
            it('should return false', function() {
                expect($this->started)->toBeFalse();
            });
            it('check mock object expectations', function() {
                call_user_func($this->verify);
            });
        });
    });

    describe('#getResult', function() {
        beforeEach(function() {
            $this->verify = function() {
                Mockery::close();
            };

            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                $rootDirectory = __DIR__ . '/fixtures/src/';

                $coverageResults = [
                    $rootDirectory . 'foo.php' => array( 1 => LineResult::EXECUTED ),
                    $rootDirectory . 'bar.php' => array( 1 => LineResult::EXECUTED ),
                    $rootDirectory . 'vendor/foo1.php' => array( 1 => LineResult::EXECUTED ),
                    $rootDirectory . 'vendor/foo2.php' => array( 1 => LineResult::EXECUTED )
                ];

                $analyzeResult = AnalyzeResult::fromArray($coverageResults);

                $driver = Mockery::mock('cloak\driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('stop')->once();
                $driver->shouldReceive('getAnalyzeResult')->twice()->andReturn($analyzeResult);

                $builder->driver($driver)
                    ->includeFile(function(FileResult $file) {
                        return $file->matchPath('src');
                    })->excludeFile(function(FileResult $file) {
                        return $file->matchPath('vendor');
                    });
            });

            $this->analyzer->start();
            $this->analyzer->stop();

            $this->result = $this->analyzer->getResult();
        });
        it('should return an instance of cloak\Result', function() {
            $files = $this->result->getFiles();
            expect($files->count())->toEqual(2);
            expect($this->result)->toBeAnInstanceOf('cloak\Result');
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

});
