<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver\adaptor;

use Exception;


/**
 * Class AdaptorNotFoundException
 * @package cloak\driver\adaptor
 */
class AdaptorNotFoundException extends Exception
{

    /**
     * @param array $messages
     */
    public function __construct(array $messages)
    {
        parent::__construct(implode("\n", $messages));
    }

}
