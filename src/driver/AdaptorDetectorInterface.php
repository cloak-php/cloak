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
 * Interface AdaptorDetectorInterface
 * @package cloak\driver
 */
interface AdaptorDetectorInterface
{

    /**
     * @return \cloak\driver\AdaptorInterface
     * @throws \cloak\driver\adaptor\AdaptorNotFoundException
     */
    public function detect();

}
