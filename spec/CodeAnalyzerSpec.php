<?php

use CodeAnalyzer\CodeAnalyzer;
use CodeAnalyzer\Configuration;

describe('CodeAnalyzer', function() {

    describe('#configure', function() {
        $subject = $this->subject = new \stdClass();
        $subject->called = 0;
        $subject->configuration = null;

        $this->configurator = function(Configuration $configuration) use ($subject) {
            $subject->called++;
            $subject->configuration = $configuration;
        };
        before(function() {
            CodeAnalyzer::configure($this->configurator);
        });
        it('should called once', function() {
            expect($this->subject->called)->toBe(1);
        });
        it('should argument is an instance of CodeAnalyzer\Configuration', function() {
            expect($this->subject->configuration)->toBeAnInstanceOf('CodeAnalyzer\Configuration');
        });
    });

    describe('#start', function() {
        it('should analyze start');
    });

    describe('#stop', function() {
        it('should analyze stop');
    });

});
