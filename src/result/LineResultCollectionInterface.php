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

use cloak\CollectionInterface;


/**
 * Interface LineResultCollectionInterface
 * @package cloak\result
 */
interface LineResultCollectionInterface
    extends CodeCoverageResult, LineResultSelectable, LineCountResult, CollectionInterface
{
}
