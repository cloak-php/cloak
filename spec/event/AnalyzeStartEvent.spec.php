<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\AnalyzeStartEvent;
use \DateTimeImmutable;

describe(AnalyzeStartEvent::class, function() {
    beforeEach(function() {
        $this->startEvent = new AnalyzeStartEvent();
    });
    describe('#getSendAt', function() {
        it('should return time send the event', function() {
            expect($this->startEvent->getSendAt())->toBeAnInstanceOf(DateTimeImmutable::class);
        });
    });
});
