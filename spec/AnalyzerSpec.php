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
use cloak\ConfigurationBuilder;
use cloak\Result;
use cloak\result\Line;
use cloak\result\File;
use Mockery as Mock;

describe('Analyzer', function() {

    $subject = $this->subject = new \stdClass();
    $subject->called = 0;
    $subject->configuration = null;

    $this->builder = function(ConfigurationBuilder $builder) use ($subject) {
        $subject->called++;
        $subject->builder = $builder;
    };

    describe('#factory', function() {
        $subject = $this->subject = new \stdClass();
        $subject->called = 0;
        $subject->configuration = null;

        $this->builder = function(ConfigurationBuilder $builder) use ($subject) {
            $subject->called++;
            $subject->builder = $builder;
        };
        $this->returnValue = Analyzer::factory($this->builder);

        it('should called once', function() {
            expect($this->subject->called)->toBe(1);
        });
        it('should argument is an instance of cloak\ConfigurationBuilder', function() {
            expect($this->subject->builder)->toBeAnInstanceOf('cloak\ConfigurationBuilder');
        });
        it('should return an instance of cloak\Analyzer', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\Analyzer');
        });
    });

    describe('#stop', function() {
        $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
            $driver = Mock::mock('cloak\Driver\DriverInterface');
            $driver->shouldReceive('start')->once();
            $driver->shouldReceive('stop')->once();
            $driver->shouldReceive('getResult')->once()->andReturn(array(
                'foo.php' => array( 1 => Line::EXECUTED )
            ));
            $builder->driver($driver);
        });

        $subject = $this->subject = new \stdClass();
        $this->notifier = Mock::mock('cloak\AnalyzeLifeCycleNotifierInterface');
        $this->notifier->shouldReceive('notifyStop')->once()->with(Mock::on(function($result) use ($subject) {
            $subject->result = $result;
            return true;
        }));

        before(function() {
            $this->analyzer->setLifeCycleNotifier($this->notifier);
            $this->analyzer->start();
            $this->analyzer->stop();
        });
        after(function() {
            Mock::close();
        });
        it('should return cloak\Result instance', function() {
            expect($this->subject->result)->toBeAnInstanceOf('cloak\Result');
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                $driver = Mock::mock('cloak\driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('isStarted')->once()->andReturn(true);
                $builder->driver($driver);
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
            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
                $driver = Mock::mock('cloak\driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('stop')->once();
                $driver->shouldReceive('isStarted')->once()->andReturn(false);
                $builder->driver($driver);
            });
            before(function() {
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
        $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {
            $rootDirectory = __DIR__ . '/fixtures/src/';

            $coverageResults = [
                $rootDirectory . 'foo.php' => array( 1 => Line::EXECUTED ),
                $rootDirectory . 'bar.php' => array( 1 => Line::EXECUTED ),
                $rootDirectory . 'vendor/foo1.php' => array( 1 => Line::EXECUTED ),
                $rootDirectory . 'vendor/foo2.php' => array( 1 => Line::EXECUTED )
            ];

            $driver = Mock::mock('cloak\driver\DriverInterface');
            $driver->shouldReceive('start')->once();
            $driver->shouldReceive('stop')->once();
            $driver->shouldReceive('getResult')->once()->andReturn($coverageResults);

            $builder->driver($driver)
                ->includeFile(function(File $file) {
                    return $file->matchPath('src');
                })->excludeFile(function(File $file) {
                    return $file->matchPath('vendor');
                });
        });

        before(function() {
            $this->analyzer->start();
            $this->analyzer->stop();
            $this->result = $this->analyzer->getResult();
        });
        after(function() {
            Mock::close();
        });
        it('should return an instance of cloak\Result', function() {
            $files = $this->result->getFiles();

            expect($files->count())->toBe(2);
            expect($this->result)->toBeAnInstanceOf('cloak\Result');
        });
    });

});
