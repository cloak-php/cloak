<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\configuration\section;

use cloak\configuration\ConfigurationBuilder;
use cloak\configuration\AbstractSection;
use cloak\configuration\Section;
use Zend\Config\Config;


/**
 * Class Target
 * @package cloak\configuration
 */
final class Target extends AbstractSection implements Section
{

    /**
     * {@inheritdoc}
     */
    public function applyTo(ConfigurationBuilder $builder)
    {
        $includes = $this->getValue('includes', new Config([]));
        $excludes = $this->getValue('excludes', new Config([]));

        $builder->includeFiles( $includes->toArray() )
            ->excludeFiles( $excludes->toArray() );

        return $builder;
    }

}
