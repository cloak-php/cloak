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


describe('Driver', function() {

    describe('#isStarted', function() {
        context('when after instantiation', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $adaptor = $this->prophet->prophesize('cloak\driver\AdaptorInterface');
                $adaptor->start()->shouldNotBeCalled();
                $adaptor->stop()->shouldNotBeCalled();

                $this->dirver = new Driver($adaptor->reveal());
            });
            it('should return false', function() {
                expect($this->dirver->isStarted())->toBeFalse();
            });
        });
    });

    describe('#getAnalyzeResult', function() {
        context('when after instantiation', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $adaptor = $this->prophet->prophesize('cloak\driver\AdaptorInterface');
                $adaptor->start()->shouldNotBeCalled();
                $adaptor->stop()->shouldNotBeCalled();

                $this->dirver = new Driver($adaptor->reveal());
            });
            it('return cloak\driver\Result', function() {
                $result = $this->driver->getAnalyzeResult();
                expect($result)->toBeAnInstanceOf('cloak\driver\Result');
            });
        });
    });

});
