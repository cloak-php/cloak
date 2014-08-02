<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;

use cloak\Result;
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;

/**
 * Class CompositeReporter
 * @package cloak\reporter
 */
class CompositeReporter implements ReporterInterface
{

    use Reportable;

    private $reporters;

    /**
     * @param array $reporters
     */
    public function __construct(array $reporters)
    {
        $this->reporters = $reporters;
    }

    /**
     * @param \cloak\event\StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
        foreach ($this->reporters as $reporter) {
            if (method_exists($reporter, 'onStart') === false) {
                continue;
            }
            $reporter->onStart($event);
        }
    }

    /**
     * @param \cloak\event\StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        foreach ($this->reporters as $reporter) {
            if (method_exists($reporter, 'onStop') === false) {
                continue;
            }
            $reporter->onStop($event);
        }
    }

}
