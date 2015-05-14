<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\FinalizeEvent;
use \DateTimeImmutable;

describe(FinalizeEvent::class, function() {
    beforeEach(function() {
        $this->event = new FinalizeEvent();
    });
    describe('#getSendAt', function() {
        it('return time send the event', function() {
            expect($this->event->getSendAt())->toBeAnInstanceOf(DateTimeImmutable::class);
        });
    });
});
