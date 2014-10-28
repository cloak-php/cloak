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

use Zend\Config\Config;


/**
 * Class Root
 * @package cloak\configuration
 */
final class Root implements NodeInterface
{

    /**
     * @var NodeInterface[]
     */
    private $configurations = [];


    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $config = new Config($values);
        $emptyConfig = new Config([]);

        $target = $config->get('target', $emptyConfig)->toArray();
        $this->configurations[] = new Target($target);

        $reporter = $config->get('reporter', $emptyConfig)->toArray();
        $this->configurations[] = new Reporter($reporter);
    }


    /**
     * {@inheritdoc}
     */
    public function applyTo(ConfigurationBuilder $builder)
    {
        foreach ($this->configurations as $configuration) {
            $configuration->applyTo($builder);
        }

        return $builder;
    }

}
