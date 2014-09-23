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
use cloak\reporter\MarkdownReporter;
use \Mockery;
use \DateTime;


describe('MarkdownReporter', function() {
    before(function() {
        $fixturePath = realpath(__DIR__ . '/../fixtures/');

        $this->source1 = $fixturePath . '/Example1.php';
        $this->source2 = $fixturePath . '/Example2.php';
        $this->markdownReport = $fixturePath . '/report.md';

        $this->startDateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-10 00:00:00');

        $coverageResults = [
            $this->source1 => [
                10 => Line::EXECUTED,
                11 => Line::EXECUTED
            ],
            $this->source2 => [
                10 => Line::UNUSED,
                15 => Line::EXECUTED
            ]
        ];

        $this->result = Result::from($coverageResults);
    });

    describe('onStop', function() {
        before(function() {
            $this->startEvent = Mockery::mock('cloak\event\StartEventInterface');
            $this->startEvent->shouldReceive('getSendAt')->once()->andReturn($this->startDateTime);

            $this->stopEvent = Mockery::mock('cloak\event\StopEventInterface');
            $this->stopEvent->shouldReceive('getResult')->once()->andReturn($this->result);

            $this->directoryPath = realpath(__DIR__ . '/../tmp/');
            $this->filePath = $this->directoryPath . '/report.md';

            $this->reporter = new MarkdownReporter($this->filePath);
            $this->reporter->onStart($this->startEvent);
            $this->reporter->onStop($this->stopEvent);

            $this->outputReport = file_get_contents($this->markdownReport);
        });

        it('output the markdown report', function() {
            expect(file_get_contents($this->filePath))->toEqual($this->outputReport);
        });
        it('check mock object expectations', function() {
            Mockery::close();
        });
    });

});
