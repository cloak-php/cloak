<?php

/**
 * This file is part of easy-coverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage;

/**
 * Interface NotifierAwareInterface
 * @package easycoverage
 */
interface NotifierAwareInterface
{

    public function setNotifier(NotifierInterface $notifier);

    public function getNotifier();

}
