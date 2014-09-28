<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\ClassResult;
use cloak\result\LineSet;
use cloak\result\Line;
use cloak\value\Coverage;
use Zend\Code\Reflection\ClassReflection;
use \Mockery;

describe('ClassResult', function() {
    before(function() {
        $lineSet = new LineSet([
            new Line(12, Line::EXECUTED),
            new Line(17, Line::UNUSED)
        ]);
        $classReflection = new ClassReflection('Example\\Example');

        $this->result = new ClassResult($classReflection, $lineSet);
    });
    describe('getName', function() {
        it('return class name', function() {
            expect($this->result->getName())->toEqual('Example\\Example');
        });
    });
    describe('getNamespaceName', function() {
        it('return namespace name', function() {
            expect($this->result->getNamespaceName())->toEqual('Example');
        });
    });
    describe('getMethodResults', function() {
        before(function() {
            $this->methodResults = $this->result->getMethodResults();
        });
        it('return cloak\result\collection\NamedResultCollection instance', function() {
            expect($this->methodResults)->toBeAnInstanceOf('cloak\result\collection\NamedResultCollection');
        });
        context('when all results', function() {
            it('return results', function() {
                expect(count($this->methodResults))->toEqual(2);
            });
        });
    });
    describe('CoverageResultInterface', function() {
        beforeEach(function() {
            $this->cleanClassLineResults = Mockery::mock('cloak\result\LineSetInterface');

            $this->classLineResults = Mockery::mock('cloak\result\LineSetInterface');
            $this->classLineResults->shouldReceive('selectRange')
                ->once()->andReturn($this->cleanClassLineResults);

            $classReflection = new ClassReflection('Example\\Example');
            $this->result = new ClassResult($classReflection, $this->classLineResults);
        });
        describe('getLineCount', function() {
            beforeEach(function() {
                $this->cleanClassLineResults->shouldReceive('getLineCount')->once();
                $this->result->getLineCount();
            });
            it('return line count', function() {
                Mockery::close();
            });
        });
        describe('getDeadLineCount', function() {
            beforeEach(function() {
                $this->cleanClassLineResults->shouldReceive('getDeadLineCount')->once();
                $this->result->getDeadLineCount();
            });
            it('return dead line count', function() {
                Mockery::close();
            });
        });
        describe('getUnusedLineCount', function() {
            beforeEach(function() {
                $this->cleanClassLineResults->shouldReceive('getUnusedLineCount')->once();
                $this->result->getUnusedLineCount();
            });
            it('return unused line count', function() {
                Mockery::close();
            });
        });
        describe('getExecutedLineCount', function() {
            beforeEach(function() {
                $this->cleanClassLineResults->shouldReceive('getExecutedLineCount')->once();
                $this->result->getExecutedLineCount();
            });
            it('return executed line count', function() {
                Mockery::close();
            });
        });
        describe('getExecutableLineCount', function() {
            beforeEach(function() {
                $this->cleanClassLineResults->shouldReceive('getExecutableLineCount')->once();
                $this->result->getExecutableLineCount();
            });
            it('return executable line count', function() {
                Mockery::close();
            });
        });
        describe('getCodeCoverage', function() {
            beforeEach(function() {
                $this->cleanClassLineResults->shouldReceive('getCodeCoverage')->once();
                $this->result->getCodeCoverage();
            });
            it('return code coverage', function() {
                Mockery::close();
            });
        });
        describe('isCoverageLessThan', function() {
            beforeEach(function() {
                $this->coverage = new Coverage(10);
                $this->cleanClassLineResults->shouldReceive('isCoverageLessThan')
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
                $this->cleanClassLineResults->shouldReceive('isCoverageGreaterEqual')
                    ->once()->with(Mockery::mustBe($this->coverage));
                $this->result->isCoverageGreaterEqual($this->coverage);
            });
            it('return greater equal result', function() {
                Mockery::close();
            });
        });
    });
});
