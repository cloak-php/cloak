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
 * Class ProvidesNotifier
 * @package cloak
 */
trait ProvidesNotifier
{

    /**
     * @var \cloak\AnalyzeLifeCycleNotifierInterface
     */
    protected $notifier;


    /**
     * @param \cloak\AnalyzeLifeCycleNotifierInterface $notifier
     * @return $this
     */
    public function setNotifier(AnalyzeLifeCycleNotifierInterface $notifier)
    {
        $this->notifier = $notifier;
        return $this;
    }

    /**
     * @return \cloak\AnalyzeLifeCycleNotifierInterface
     */
    public function getNotifier()
    {
        if ($this->notifier === null) {
            $this->notifier = new AnalyzeLifeCycleNotifier();
        }

        return $this->notifier;
    }

}
