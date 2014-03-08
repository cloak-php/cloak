<?php

use CodeAnalyzer\Analyzer;
use CodeAnalyzer\Configuration;
use CodeAnalyzer\Result\Line;
use CodeAnalyzer\Result\File;
use CodeAnalyzer\Driver\DriverInterface;
use Mockery as Mock;


describe('Analyzer', function() {

    $subject = $this->subject = new \stdClass();
    $subject->called = 0;
    $subject->configuration = null;

    $this->configurator = function(Configuration $configuration) use ($subject) {
        $subject->called++;
        $subject->configuration = $configuration;
    };

    describe('#configure', function() {
        before(function() {
            Analyzer::configure($this->configurator);
        });
        it('should called once', function() {
            expect($this->subject->called)->toBe(1);
        });
        it('should argument is an instance of CodeAnalyzer\Configuration', function() {
            expect($this->subject->configuration)->toBeAnInstanceOf('CodeAnalyzer\Configuration');
        });
    });

    describe('#isStarted', function() {
        context('when started', function() {
            before(function() {
                $this->driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $this->driver->shouldReceive('start')->once();
                $this->driver->shouldReceive('isStarted')->once()->andReturn(true);
                $this->analyzer = new Analyzer($this->driver);
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
                $this->driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
                $this->driver->shouldReceive('start')->once();
                $this->driver->shouldReceive('stop')->once();
                $this->driver->shouldReceive('getResult')->once()->andReturn(array(
                    'foo.php' => array( Line::EXECUTED => 1 )
                ));
                $this->driver->shouldReceive('isStarted')->once()->andReturn(false);
                $this->analyzer = new Analyzer($this->driver);
                $this->analyzer->start();
            });
            after(function() {
                Mock::close();
            });
            it('should return false', function() {
                $this->analyzer->stop();
                expect($this->analyzer->isStarted())->toBeFalse();
            });
        });
    });

    describe('#getResult', function() {
        before(function() {
            $this->driver = Mock::mock('CodeAnalyzer\Driver\DriverInterface');
            $this->driver->shouldReceive('start')->once();
            $this->driver->shouldReceive('stop')->once();
            $this->driver->shouldReceive('getResult')->once()->andReturn(array(
                'src/foo.php' => array( Line::EXECUTED => 1 ),
                'src/bar.php' => array( Line::EXECUTED => 1 ),
                'src/vendor/foo1.php' => array( Line::EXECUTED => 1 ),
                'src/vendor/foo2.php' => array( Line::EXECUTED => 1 )
            ));
            Analyzer::configure(function(Configuration $configuration) {
                $configuration->includeFile(function(File $file) {
                    return $file->matchPath('src');
                })->excludeFile(function(File $file) {
                    return $file->matchPath('vendor');
                });
            });
            $this->analyzer = new Analyzer($this->driver);
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
