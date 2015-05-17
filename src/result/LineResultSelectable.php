<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result;


use cloak\value\LineRange;
use cloak\reflection\Reflection;


/**
 * Interface LineResultSelectable
 * @package cloak\result
 */
interface LineResultSelectable
{

    /**
     * @param LineRange $lineRange
     * @return \cloak\result\collection\LineResultCollection
     */
    public function selectRange(LineRange $lineRange);

    /**
     * @param Reflection $reflection
     * @return \cloak\result\collection\LineResultCollection
     */
    public function selectByReflection(Reflection $reflection);

}
