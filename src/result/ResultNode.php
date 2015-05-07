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


/**
 * Interface ResultNode
 * @package cloak
 */
interface ResultNode
{

    /**
     * @return bool
     */
    public function hasChildResults();

    /**
     * @return \cloak\result\CoverageResultCollectionInterface
     */
    public function getChildResults();

    /**
     * @param CoverageResultVisitorInterface $visitor
     */
    public function accept(CoverageResultVisitorInterface $visitor);

}
