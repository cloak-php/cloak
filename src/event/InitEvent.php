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
use cloak\value\CoverageBounds;
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
    private $config;


    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->sendAt = new DateTime();
        $this->config = $config;
    }

    /**
     * @return CoverageBounds
     */
    public function getCoverageBounds()
    {
        //FIXME That reference configuration!!!!!
        return new CoverageBounds(35.0, 80.0);
    }

    /**
     * return string
     * FIXME That reference configuration!!!!!
     */
    public function getReportDirectory()
    {
    }

}
