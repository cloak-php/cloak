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
use \Prophecy\Prophet;
use \Prophecy\Argument;


describe('Analyzer', function() {
    describe('#stop', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/fixtures/src/';

            $analyzeResult = AnalyzeResult::fromArray([
                $rootDirectory . 'foo.php' => [
                    1 => LineResult::EXECUTED
                ]
            ]);

            $this->prophet = new Prophet();

            $driver = $this->prophet->prophesize('cloak\driver\DriverInterface');
            $driver->start()->shouldBeCalled();
            $driver->stop()->shouldBeCalled();
            $driver->getAnalyzeResult()->willReturn($analyzeResult);
            $driver->isStarted()->shouldNotBeCalled();

            $notifier = $this->prophet->prophesize('cloak\AnalyzeLifeCycleNotifierInterface');
            $notifier->notifyStart()->shouldBeCalled();
            $notifier->notifyStop(Argument::type('cloak\Result'))->shouldBeCalled();

            $builder = new ConfigurationBuilder();
            $builder->driver( $driver->reveal() );

            $config = $builder->build();

            $this->analyzer = new Analyzer($config);
            $this->analyzer->setLifeCycleNotifier( $notifier->reveal() );
            $this->analyzer->start();
            $this->analyzer->stop();

            $this->result = $this->analyzer->getResult();
        });
        it('return cloak\Result instance', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\Result');
        });
        it('notify stop event', function() {
            $this->prophet->checkPredictions();
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $driver = $this->prophet->prophesize('cloak\driver\DriverInterface');
                $driver->start()->shouldBeCalled();
                $driver->stop()->shouldNotBeCalled();
                $driver->getAnalyzeResult()->shouldNotBeCalled();
                $driver->isStarted()->willReturn(true);

                $builder = new ConfigurationBuilder();
                $builder->driver( $driver->reveal() );

                $config = $builder->build();

                $this->analyzer = new Analyzer($config);
                $this->analyzer->start();

                $this->started = $this->analyzer->isStarted();
            });
            it('return true', function() {
                expect($this->started)->toBeTrue();
            });
        });
        context('when stoped', function() {
            beforeEach(function() {
                $rootDirectory = __DIR__ . '/fixtures/src/';

                $analyzeResult = AnalyzeResult::fromArray([
                    $rootDirectory . 'foo.php' => [
                        1 => LineResult::EXECUTED
                    ]
                ]);

                $this->prophet = new Prophet();

                $driver = $this->prophet->prophesize('cloak\driver\DriverInterface');
                $driver->start()->shouldBeCalled();
                $driver->stop()->shouldBeCalled();

                $driver->getAnalyzeResult()->willReturn($analyzeResult);
                $driver->isStarted()->willReturn(false);

                $builder = new ConfigurationBuilder();
                $builder->driver( $driver->reveal() );

                $config = $builder->build();

                $this->analyzer = new Analyzer($config);
                $this->analyzer->start();
                $this->analyzer->stop();

                $this->started = $this->analyzer->isStarted();
            });
            it('return false', function() {
                expect($this->started)->toBeFalse();
            });
        });
    });

    describe('#getResult', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/fixtures/src/';

            $coverageResults = [
                $rootDirectory . 'foo.php' => array( 1 => LineResult::EXECUTED ),
                $rootDirectory . 'bar.php' => array( 1 => LineResult::EXECUTED ),
                $rootDirectory . 'vendor/foo1.php' => array( 1 => LineResult::EXECUTED ),
                $rootDirectory . 'vendor/foo2.php' => array( 1 => LineResult::EXECUTED )
            ];

            $analyzeResult = AnalyzeResult::fromArray($coverageResults);

            $this->prophet = new Prophet();

            $driver = $this->prophet->prophesize('cloak\driver\DriverInterface');
            $driver->start()->shouldBeCalledTimes(1);
            $driver->stop()->shouldBeCalledTimes(1);
            $driver->getAnalyzeResult()->willReturn($analyzeResult);
            $driver->isStarted()->shouldNotBeCalled();

            $builder = new ConfigurationBuilder();
            $builder->driver( $driver->reveal() )
                ->includeFile('src')
                ->excludeFile('vendor');

            $config = $builder->build();

            $this->analyzer = new Analyzer($config);
            $this->analyzer->start();
            $this->analyzer->stop();

            $this->result = $this->analyzer->getResult();

        });
        it('should return an instance of cloak\Result', function() {
            $files = $this->result->getFiles();
            expect($files->count())->toEqual(2);
            expect($this->result)->toBeAnInstanceOf('cloak\Result');
        });
    });

});
