<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Result;
use cloak\result\Line;
use cloak\AnalyzeLifeCycleNotifier;
use Mockery as Mock;

describe('AnalyzeLifeCycleNotifier', function() {

    describe('#notifyStop', function() {
        $rootDirectory = __DIR__ . '/fixtures/src/';
        $coverageResults = [
            $rootDirectory . 'foo.php' => array( 1 => Line::EXECUTED )
        ];

        $this->result = Result::from($coverageResults);

        $subject = $this->subject = new \stdClass();
        $reporter = $this->reporter = Mock::mock('cloak\reporter\ReporterInterface');

        $reporter->shouldReceive('attach')->once()->with(
            Mockery::on(function($eventManager) use ($reporter) {
                $eventManager->attach('stop', array($reporter, 'onStop'));
                return true;
            })
        );

        $reporter->shouldReceive('onStop')->once()->with(
            Mockery::on(function($event) use($subject) {
                $subject->event = $event;
                return true;
            })
        );

        $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporter);
        $this->progessNotifier->notifyStop($this->result);

        it('should notify the reporter that it has stopped', function() {
            $event = $this->subject->event;
            expect($event)->toBeAnInstanceOf('cloak\StopEventInterface');
        });

        it('should include the results', function() {
            $result = $this->subject->event->getResult();
            expect($result)->toEqual($this->result);
            expect(count($result->getFiles()))->toBe(1);
        });
    });

});
