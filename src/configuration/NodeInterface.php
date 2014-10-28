<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\configuration;


/**
 * Interface NodeInterface
 * @package cloak\configuration
 */
interface NodeInterface
{

    /**
     * @param ConfigurationBuilder $builder
     * @return ConfigurationBuilder
     */
    public function applyTo(ConfigurationBuilder $builder);

}
