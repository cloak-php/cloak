<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use \Mockery as Mock;

describe('Event', function() {

    describe('#getSendAt', function() {
        before(function() {
            $this->event = Mock::mock('cloak\event\Event', [])->makePartial();
        });
        it('should return time send the event', function() {
            expect($this->event->getSendAt())->toBeAnInstanceOf('\DateTimeImmutable');
        });
    });

});
