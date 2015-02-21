<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver;


/**
 * Interface AdaptorInterface
 * @package cloak\driver
 */
interface AdaptorInterface
{

    public function start();

    /**
     * @return array
     */
    public function stop();

}
