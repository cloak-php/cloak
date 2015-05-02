<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Configuration;
use cloak\event\InitEvent;
use cloak\value\Path;
use \DateTimeImmutable;

describe(InitEvent::class, function() {
    beforeEach(function() {
        $configuration = new Configuration([
            'reportDirectory' => __DIR__
        ]);
        $this->initEvent = new InitEvent($configuration);
    });
    describe('#getSendAt', function() {
        it('return time send the event', function() {
            expect($this->initEvent->getSendAt())->toBeAnInstanceOf(DateTimeImmutable::class);
        });
    });
    describe('#getReportDirectory', function() {
        it('return report directory path', function() {
            expect($this->initEvent->getReportDirectory())->toBeAnInstanceOf(Path::class);
        });
    });
});
