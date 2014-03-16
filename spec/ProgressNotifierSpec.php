<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Result,
    CodeAnalyzer\Result\Line,
    CodeAnalyzer\Notifier,
    Mockery as Mock;

describe('Notifier', function() {

    describe('#stop', function() {
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

            $this->progessNotifier = new Notifier($reporter);
            $this->progessNotifier->stop($this->result);
        });
        it('should notify the reporter that it has stopped', function() {
            $event = $this->subject->event;
            expect($event)->toBeAnInstanceOf('CodeAnalyzer\EventInterface');
        });
        it('should include the results', function() {
            $result = $this->subject->event->getResult();
            expect($result)->toEqual($this->result);
        });
    });

});
