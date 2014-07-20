<?php

/**
 * This file is part of easy-coverage.
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

    protected $notifier = null;

    /**
     * @param \cloak\NotifierInterface $notifier
     * @return $this
     */
    public function setNotifier(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
        return $this;
    }

    /**
     * @return \cloak\NotifierInterface
     */
    public function getNotifier()
    {
        if ($this->notifier === null) {
            $this->notifier = new Notifier();
        }

        return $this->notifier;
    }

}
