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

use Yosymfony\Toml\Toml;
use cloak\driver\result\FileResult;


/**
 * Class ConfigurationLoader
 * @package cloak
 */
class ConfigurationLoader
{

    /**
     * @param string $configFilePath
     * @return \cloak\Configuration
     */
    public static function loadConfigration($configFilePath)
    {
        $configValues = Toml::Parse($configFilePath);
        $defaults = $configValues['defaults'];

        $builder = new ConfigurationBuilder();
        $builder->includeFile(function (FileResult $file) {
            return $file->matchPaths($defaults['includes']);
        })->excludeFile(function (FileResult $file) {
            return $file->matchPaths($defaults['excludes']);
        });

        return $builder->build();
    }

}
