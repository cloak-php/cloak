<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\writer;

use Zend\Console\Console;


/**
 * Class ConsoleWriter
 * @package cloak\writer
 */
class ConsoleWriter extends AbstractConsoleWriter implements ConsoleWriterInterface
{

    public function __construct()
    {
        $this->console = Console::getInstance();
    }

}
