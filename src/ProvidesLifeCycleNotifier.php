<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

/**
 * Trait ProvidesLifeCycleNotifier
 * @package cloak
 */
trait ProvidesLifeCycleNotifier
{

    /**
     * @var \cloak\LifeCycleNotifier
     */
    protected $notifier;


    /**
     * @param \cloak\LifeCycleNotifier $notifier
     * @return $this
     */
    public function setLifeCycleNotifier(LifeCycleNotifier $notifier)
    {
        $this->notifier = $notifier;
        return $this;
    }

    /**
     * @return \cloak\LifeCycleNotifier
     */
    public function getLifeCycleNotifier()
    {
        $this->notifier = $this->notifier ?: new AnalyzeLifeCycleNotifier();

        return $this->notifier;
    }

}
