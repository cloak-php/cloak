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

use cloak\event\AnalyzeStartEvent;

/**
 * Interface AnalyzeStartEventListener
 * @package cloak\reporter
 */
interface AnalyzeStartEventListener
{

    /**
     * @param AnalyzeStartEvent $event
     * @return mixed
     */
    public function onStart(AnalyzeStartEvent $event);

}
