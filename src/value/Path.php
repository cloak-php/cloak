<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\value;

use Eloquent\Pathogen\Factory\PathFactory;
use Eloquent\Pathogen\RelativePath;


/**
 * Class Path
 * @package cloak\value
 */
final class Path
{

    /**
     * @var \Eloquent\Pathogen\PathInterface
     */
    private $rootPath;


    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->rootPath = PathFactory::instance()->create($path);
    }

    /**
     * @param string $path
     */
    public function join($path)
    {
        $relativePath = RelativePath::fromString($path);

        $resultPath = $this->rootPath->join($relativePath);
        $newRootPath = $resultPath->normalize()->string();

        return Path::fromString($newRootPath);
    }

    /**
     * @return string
     */
    public function stringify()
    {
        return $this->rootPath->normalize()->string();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->stringify();
    }

    /**
     * @param string $path
     * @return Path
     */
    public static function fromString($path)
    {
        return new self($path);
    }

}
