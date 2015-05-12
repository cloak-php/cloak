<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\CoverageAnalyzer;
use cloak\configuration\ConfigurationBuilder;
use cloak\Result;
use cloak\analyzer\AnalyzeDriver;
use cloak\analyzer\AnalyzedResult;
use cloak\analyzer\result\LineResult;
use cloak\LifeCycleNotifier;
use \Prophecy\Prophet;
use \Prophecy\Argument;


describe(CoverageAnalyzer::class, function() {
    describe('#stop', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/fixtures/src/';

            $analyzeResult = AnalyzedResult::fromArray([
                $rootDirectory . 'foo.php' => [
                    1 => LineResult::EXECUTED
                ]
            ]);

            $this->prophet = new Prophet();

            $driver = $this->prophet->prophesize(AnalyzeDriver::class);
            $driver->start()->shouldBeCalled();
            $driver->stop()->shouldBeCalled();
            $driver->getAnalyzeResult()->willReturn($analyzeResult);
            $driver->isStarted()->shouldNotBeCalled();

            $notifier = $this->prophet->prophesize(LifeCycleNotifier::class);
            $notifier->notifyStart()->shouldBeCalled();
            $notifier->notifyStop(Argument::type(Result::class))->shouldBeCalled();

            $builder = new ConfigurationBuilder();
            $builder->driver( $driver->reveal() );

            $config = $builder->build();

            $this->analyzer = new CoverageAnalyzer($config);
            $this->analyzer->setLifeCycleNotifier( $notifier->reveal() );
            $this->analyzer->start();
            $this->analyzer->stop();

            $this->result = $this->analyzer->getResult();
        });
        it('return cloak\Result instance', function() {
            expect($this->result)->toBeAnInstanceOf(Result::class);
        });
        it('notify stop event', function() {
            $this->prophet->checkPredictions();
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $driver = $this->prophet->prophesize(AnalyzeDriver::class);
                $driver->start()->shouldBeCalled();
                $driver->stop()->shouldNotBeCalled();
                $driver->getAnalyzeResult()->shouldNotBeCalled();
                $driver->isStarted()->willReturn(true);

                $builder = new ConfigurationBuilder();
                $builder->driver( $driver->reveal() );

                $config = $builder->build();

                $this->analyzer = new CoverageAnalyzer($config);
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

                $analyzeResult = AnalyzedResult::fromArray([
                    $rootDirectory . 'foo.php' => [
                        1 => LineResult::EXECUTED
                    ]
                ]);

                $this->prophet = new Prophet();

                $driver = $this->prophet->prophesize(AnalyzeDriver::class);
                $driver->start()->shouldBeCalled();
                $driver->stop()->shouldBeCalled();

                $driver->getAnalyzeResult()->willReturn($analyzeResult);
                $driver->isStarted()->willReturn(false);

                $builder = new ConfigurationBuilder();
                $builder->driver( $driver->reveal() );

                $config = $builder->build();

                $this->analyzer = new CoverageAnalyzer($config);
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

            $analyzeResult = AnalyzedResult::fromArray($coverageResults);

            $this->prophet = new Prophet();

            $driver = $this->prophet->prophesize(AnalyzeDriver::class);
            $driver->start()->shouldBeCalledTimes(1);
            $driver->stop()->shouldBeCalledTimes(1);
            $driver->getAnalyzeResult()->willReturn($analyzeResult);
            $driver->isStarted()->shouldNotBeCalled();

            $builder = new ConfigurationBuilder();
            $builder->driver( $driver->reveal() )
                ->includeFile('src')
                ->excludeFile('vendor');

            $config = $builder->build();

            $this->analyzer = new CoverageAnalyzer($config);
            $this->analyzer->start();
            $this->analyzer->stop();

            $this->result = $this->analyzer->getResult();

        });
        it('should return an instance of cloak\Result', function() {
            $files = $this->result->getFiles();
            expect($files->count())->toEqual(2);
            expect($this->result)->toBeAnInstanceOf(Result::class);
        });
    });

});
