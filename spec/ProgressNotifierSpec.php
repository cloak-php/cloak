<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Result;
use CodeAnalyzer\Result\Line;
use CodeAnalyzer\ProgressNotifier;
use Mockery as Mock;

describe('ProgressNotifier', function() {

    describe('#notifyStop', function() {
        before(function() {
            $this->result = Result::from(array(
                'foo.php' => array(
                    1 => Line::EXECUTED
                )
            ));

            $subject = $this->subject = new \stdClass();
            $reporter = $this->reporter = Mock::mock('CodeAnalyzer\Reporter\ReporterInterface');

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

            $this->progessNotifier = new ProgressNotifier($reporter);
            $this->progessNotifier->notifyStop($this->result);
        });
        it('should notify the reporter that it has stopped', function() {
            $event = $this->subject->event;
            expect($event)->toBeAnInstanceOf('Zend\EventManager\EventInterface');
        });
        it('should include the results', function() {
            $result = $this->subject->event->getResult();
            expect($result)->toEqual($this->result);
        });
    });

});
