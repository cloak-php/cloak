<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


use Prophecy\Prophet;
use cloak\driver\Driver;
use cloak\driver\AdaptorInterface;
use cloak\driver\Result;


describe(Driver::class, function() {

    describe('#isStarted', function() {
        context('when after instantiation', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $adaptor = $this->prophet->prophesize(AdaptorInterface::class);
                $adaptor->start()->shouldNotBeCalled();
                $adaptor->stop()->shouldNotBeCalled();

                $this->dirver = new Driver($adaptor->reveal());
            });
            it('return false', function() {
                expect($this->dirver->isStarted())->toBeFalse();
            });
        });
        context('when started', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $adaptor = $this->prophet->prophesize(AdaptorInterface::class);
                $adaptor->start()->shouldBeCalled();
                $adaptor->stop()->shouldNotBeCalled();

                $this->dirver = new Driver($adaptor->reveal());
            });
            it('return true', function() {
                $this->dirver->start();
                expect($this->dirver->isStarted())->toBeTrue();
            });
        });
        context('when stoped', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $adaptor = $this->prophet->prophesize(AdaptorInterface::class);
                $adaptor->start()->shouldBeCalled();
                $adaptor->stop()->shouldBeCalled();

                $this->dirver = new Driver($adaptor->reveal());
            });
            it('return true', function() {
                $this->dirver->start();
                $this->dirver->stop();
                expect($this->dirver->isStarted())->toBeFalse();
            });
        });
    });

    describe('#getAnalyzeResult', function() {
        context('when after instantiation', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $adaptor = $this->prophet->prophesize(AdaptorInterface::class);
                $adaptor->start()->shouldNotBeCalled();
                $adaptor->stop()->shouldNotBeCalled();

                $this->driver = new Driver($adaptor->reveal());
            });
            it('return cloak\driver\Result', function() {
                $result = $this->driver->getAnalyzeResult();
                expect($result)->toBeAnInstanceOf(Result::class);
            });
        });
    });

});
