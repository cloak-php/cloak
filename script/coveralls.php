<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\script;

require_once __DIR__ . "/../vendor/autoload.php";

use coverallskit\Configuration;
use coverallskit\ReportBuilder;

$configuration = Configuration::loadFromFile('.coveralls.yml');
$builder = ReportBuilder::fromConfiguration($configuration);
$builder->build()->save()->upload();
