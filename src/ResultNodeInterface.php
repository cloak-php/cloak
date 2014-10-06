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
 * Interface ResultNodeInterface
 * @package cloak
 */
interface ResultNodeInterface
{

    /**
     * @return bool
     */
    public function hasChildResults();

    /**
     * @return \cloak\result\NamedResultCollectionInterface
     */
    public function getChildResults();

}
