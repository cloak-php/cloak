<?php

use CodeAnalyzer\CodeAnalyzer;
use CodeAnalyzer\Configuration;
use CodeAnalyzer\Result\File;

describe('CodeAnalyzer', function() {

    $subject = $this->subject = new \stdClass();
    $subject->called = 0;
    $subject->configuration = null;

    $this->configurator = function(Configuration $configuration) use ($subject) {
        $subject->called++;
        $subject->configuration = $configuration;
    };
    $this->analyzer = new CodeAnalyzer(); 

    before(function() {
        CodeAnalyzer::configure($this->configurator);
    });

    describe('#configure', function() {
        it('should called once', function() {
            expect($this->subject->called)->toBe(1);
        });
        it('should argument is an instance of CodeAnalyzer\Configuration', function() {
            expect($this->subject->configuration)->toBeAnInstanceOf('CodeAnalyzer\Configuration');
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            it('should return true', function() {
                $this->analyzer->start();
                expect($this->analyzer->isStarted())->toBeTrue();
            });
        });
        context('when stoped', function() {
            it('should return false', function() {
                $this->analyzer->start();
                $this->analyzer->stop();
                expect($this->analyzer->isStarted())->toBeFalse();
            });
        });
    });

    describe('#start', function() {
        before(function() {
            $this->analyzer->start();
        });
        it('should analyze start', function() {
            expect($this->analyzer->isStarted())->toBeTrue();
        });
    });

    describe('#stop', function() {
        before(function() {
            $this->analyzer->stop();
        });
        it('should analyze stop', function() {
            expect($this->analyzer->isStarted())->toBeFalse();
        });
    });

    describe('#getResult', function() {
        before(function() {
            CodeAnalyzer::configure(function(Configuration $configuration) {
                $configuration->includeFile(function(File $file) {
                    return $file->matchPath('src');
                })->excludeFile(function(File $file) {
                    return $file->matchPath('vendor');
                });
            });
            $this->analyzer->start();
            $this->analyzer->stop();
            $this->result = $this->analyzer->getResult();
        });
        it('should return an instance of CodeAnalyzer\Result', function() {
            expect($this->result)->toBeAnInstanceOf('CodeAnalyzer\Result');
            expect($this->result->count())->toBe(1);
        });
    });

});
