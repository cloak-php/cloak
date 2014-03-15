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
use CodeAnalyzer\Reporter\ReporterInterface;
use Zend\EventManager\EventInterface;
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
                $subject = new stdClass();
                $reporter = $this->reporter = Mock::mock('CodeAnalyzer\Reporter\ReporterInterface');

                $attach = Mockery::on(function($eventManager) use ($reporter) {
                    $eventManager->attach('stop', array($reporter, 'onStop'));
                    return true;
                });
                $onStop = Mockery::on(function($event) use($subject) {
                    $subject->event = $event;
                    return true;
                });

                $reporter->shouldReceive('attach')->once()->with($attach);
                $reporter->shouldReceive('onStop')->once()->with($onStop);

                $this->subject = $subject;

                $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) use ($reporter) {
                    $driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                    $driver->shouldReceive('start')->once();
                    $driver->shouldReceive('stop')->once();
                    $driver->shouldReceive('getResult')->once()->andReturn(array(
                        'foo.php' => array( 1 => Line::EXECUTED )
                    ));
                    $driver->shouldReceive('isStarted')->once()->andReturn(false);
                    $builder->driver($driver);
                    $builder->reporter($reporter);
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
            it('should should notify the reporter that it has stopped', function() {
                $event = $this->subject->event;
                expect($event)->toBeAnInstanceOf('Zend\EventManager\EventInterface');
            });
        });
    });

    describe('#getResult', function() {
        before(function() {
            $reporter = $this->reporter = Mock::mock('CodeAnalyzer\Reporter\ReporterInterface');
            $reporter->shouldReceive('attach')->once()->with(Mockery::any());

            $this->analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) use ($reporter) {
                $driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $driver->shouldReceive('start')->once();
                $driver->shouldReceive('stop')->once();
                $driver->shouldReceive('getResult')->once()->andReturn(array(
                    'src/foo.php' => array( 1 => Line::EXECUTED ),
                    'src/bar.php' => array( 1 => Line::EXECUTED ),
                    'src/vendor/foo1.php' => array( 1 => Line::EXECUTED ),
                    'src/vendor/foo2.php' => array( 1 => Line::EXECUTED )
                ));

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
