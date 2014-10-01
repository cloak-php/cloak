<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver\result;

/**
 * Class File
 * @package cloak\driver\result
 */
class File
{

    /**
     * @var string
     */
    private $path;


    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $realpath = realpath($path);

        if ($realpath === false) {
            throw new FileNotFoundException("'$path' file does not exist");
        }
        $this->path = $realpath;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function matchPath($path)
    {
        $pathPattern = preg_quote($path, '/');
        $result = preg_match("/" . $pathPattern . "/", $this->getPath());

        return ($result === 0) ? false : true;
    }

}
