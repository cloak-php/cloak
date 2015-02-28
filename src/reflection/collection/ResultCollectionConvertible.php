<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reflection\collection;

use cloak\result\LineResultSelectable;


/**
 * Interface ResultsConvertible
 * @package cloak\reflection
 */
interface ResultCollectionConvertible
{

    /**
     * @param LineResultSelectable $selector
     * @return \cloak\result\CoverageResultCollectionInterface;

     */
    public function convertToResult(LineResultSelectable $selector);

}
