<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\report;

/**
 * Class TextReport
 * @package cloak\report
 */
class TextReport implements ReportInterface
{

    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Print a report
     */
    public function output()
    {
        echo $this;
    }

    public function __toString()
    {
        return $this->content;
    }

}
