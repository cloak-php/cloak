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

trait ProvidesNotifier
{

    protected $notifier = null;

    /**
     * @param \CodeAnalyzer\NotifierInterface $notifier
     * @return $this
     */
    public function setNotifier(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
        return $this;
    }

    /**
     * @return \CodeAnalyzer\NotifierInterface
     */
    public function getNotifier()
    {
        if ($this->notifier === null) {
            $this->notifier = new Notifier();
        }

        return $this->notifier;
    }

}
