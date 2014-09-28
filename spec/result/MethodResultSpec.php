<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\MethodResult;
use cloak\result\LineSet;
use cloak\result\Line;
use cloak\value\Coverage;
use Zend\Code\Reflection\MethodReflection;
use \Mockery;


describe('MethodResult', function() {
    before(function() {
        $lineSet = new LineSet([
            new Line(12, Line::EXECUTED)
        ]);
        $methodReflection = new MethodReflection('Example\\Example', '__construct');
        $this->result = new MethodResult($methodReflection, $lineSet);
    });
    describe('getName', function() {
        it('return method name', function() {
            expect($this->result->getName())->toEqual('__construct');
        });
    });
    describe('getNamespaceName', function() {
        it('return namespace name', function() {
            expect($this->result->getNamespaceName())->toEqual('Example');
        });
    });

    describe('NamedCoverageResultInterface', function() {
        beforeEach(function() {
            $this->cleanMethodLineResults = Mockery::mock('cloak\result\LineSetInterface');

            $this->methodLineResults = Mockery::mock('cloak\result\LineSetInterface');
            $this->methodLineResults->shouldReceive('selectRange')
                ->once()->andReturn($this->cleanMethodLineResults);

            $methodReflection = new MethodReflection('Example\\Example', '__construct');
            $this->result = new MethodResult($methodReflection, $this->methodLineResults);
        });
        describe('getLineCount', function() {
            beforeEach(function() {
                $this->cleanMethodLineResults->shouldReceive('getLineCount')->once();
                $this->result->getLineCount();
            });
            it('return line count', function() {
                Mockery::close();
            });
        });
        describe('getDeadLineCount', function() {
            beforeEach(function() {
                $this->cleanMethodLineResults->shouldReceive('getDeadLineCount')->once();
                $this->result->getDeadLineCount();
            });
            it('return dead line count', function() {
                Mockery::close();
            });
        });
        describe('getUnusedLineCount', function() {
            beforeEach(function() {
                $this->cleanMethodLineResults->shouldReceive('getUnusedLineCount')->once();
                $this->result->getUnusedLineCount();
            });
            it('return unused line count', function() {
                Mockery::close();
            });
        });
        describe('getExecutedLineCount', function() {
            beforeEach(function() {
                $this->cleanMethodLineResults->shouldReceive('getExecutedLineCount')->once();
                $this->result->getExecutedLineCount();
            });
            it('return executed line count', function() {
                Mockery::close();
            });
        });
        describe('getExecutableLineCount', function() {
            beforeEach(function() {
                $this->cleanMethodLineResults->shouldReceive('getExecutableLineCount')->once();
                $this->result->getExecutableLineCount();
            });
            it('return executable line count', function() {
                Mockery::close();
            });
        });
        describe('getCodeCoverage', function() {
            beforeEach(function() {
                $this->cleanMethodLineResults->shouldReceive('getCodeCoverage')->once();
                $this->result->getCodeCoverage();
            });
            it('return code coverage', function() {
                Mockery::close();
            });
        });
        describe('isCoverageLessThan', function() {
            beforeEach(function() {
                $this->coverage = new Coverage(10);
                $this->cleanMethodLineResults->shouldReceive('isCoverageLessThan')
                    ->once()->with(Mockery::mustBe($this->coverage));
                $this->result->isCoverageLessThan($this->coverage);
            });
            it('return less than result', function() {
                Mockery::close();
            });
        });
        describe('isCoverageGreaterEqual', function() {
            beforeEach(function() {
                $this->coverage = new Coverage(10);
                $this->cleanMethodLineResults->shouldReceive('isCoverageGreaterEqual')
                    ->once()->with(Mockery::mustBe($this->coverage));
                $this->result->isCoverageGreaterEqual($this->coverage);
            });
            it('return greater equal result', function() {
                Mockery::close();
            });
        });
    });
});
