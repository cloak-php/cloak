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

use cloak\driver\result\FileResult;
use Zend\Config\Config;


/**
 * Class Target
 * @package cloak\configuration
 */
final class Target extends AbstractNode implements NodeInterface
{

    /**
     * {@inheritdoc}
     */
    public function applyTo(ConfigurationBuilder $builder)
    {
        $includeCallback = $this->createCallback('includes');
        $excludeCallback = $this->createCallback('excludes');

        $builder->includeFile($includeCallback)
            ->excludeFile($excludeCallback);

        return $builder;
    }

    /**
     * @param string $key
     * @return \Closure
     */
    private function createCallback($key)
    {
        $targetPaths = $this->values->get($key, new Config([]));

        $filterCallback = function (FileResult $file) use ($targetPaths) {
            $paths = $targetPaths->toArray();
            return $file->matchPaths($paths);
        };

        return $filterCallback;
    }

}
