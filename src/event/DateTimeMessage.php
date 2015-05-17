<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\event;

use DateTimeImmutable;

/**
 * Trait DateTimeMessage
 * @package cloak\event
 */
trait DateTimeMessage
{

    /**
     * @var \DateTimeImmutable
     */
    private $sendAt;

    /**
     * @return \DateTimeImmutable
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

}
