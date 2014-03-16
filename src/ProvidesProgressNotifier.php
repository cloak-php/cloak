<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer;

trait ProvidesProgressNotifier
{

    protected $notifier = null;

    public function setNotifier(ProgressNotifierInterface $notifier)
    {
        $this->notifier = $notifier;
        return $this;
    }

    public function getNotifier()
    {
        return $this->notifier;
    }

}
