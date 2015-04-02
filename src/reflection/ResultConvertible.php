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

use cloak\result\LineResultSelectable;


/**
 * Interface ResultConvertible
 * @package cloak\reflection
 */
interface ResultConvertible
{

    /**
     * @param LineResultSelectable $selector
     * @return \cloak\result\CoverageResultInterface
     */
    public function convertToResult(LineResultSelectable $selector);

}
