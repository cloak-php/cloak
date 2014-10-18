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


/***
 * Class CoverageResultInterface
 * @package cloak\result
 */
interface CoverageResultInterface extends CodeCoverageResultInterface, LineResultInterface, ResultNodeInterface
{

    /**
     * @return string
     */
    public function getName();

}
