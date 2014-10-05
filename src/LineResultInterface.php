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
 * Interface LineResultInterface
 * @package cloak
 */
interface LineResultInterface
{

    /**
     * @return int
     */
    public function getLineCount();

    /**
     * @return int
     */
    public function getDeadLineCount();

    /**
     * @return int
     */
    public function getUnusedLineCount();

    /**
     * @return int
     */
    public function getExecutedLineCount();

    /**
     * @return int
     */
    public function getExecutableLineCount();

}
