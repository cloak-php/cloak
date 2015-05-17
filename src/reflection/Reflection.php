<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reflection;

use cloak\value\LineRange;


/**
 * Interface Reflection
 * @package cloak\reflection
 */
interface Reflection
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIdentityName();

    /**
     * @return LineRange
     */
    public function getLineRange();

}
