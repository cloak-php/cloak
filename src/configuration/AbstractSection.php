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
 * Class AbstractNode
 * @package cloak\configuration
 */
abstract class AbstractSection implements SectionInterface
{

    /**
     * @var Config
     */
    protected $values;


    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = new Config($values);
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get($key, $defaultValue)
    {
        return $this->values->get($key, $defaultValue);
    }

}
