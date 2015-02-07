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

use cloak\Configuration;
use \DateTime;


/**
 * Class InitEvent
 * @package cloak\event
 */
final class InitEvent extends Event implements EventInterface
{

    /**
     * @var Configuration
     */
    private $configuration;


    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->sendAt = new DateTime();
        $this->configuration = $configuration;
    }

}
