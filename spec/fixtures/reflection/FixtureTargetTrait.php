<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\spec\reflection;

/**
 * Class FixtureTargetTrait
 * @package cloak\spec\reflection
 */
trait FixtureTargetTrait
{
    public function foo()
    {
        return true;
    }
    public function bar()
    {
        return false;
    }
}
