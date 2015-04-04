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

use cloak\value\Path;


/**
 * Class FileResult
 * @package cloak\driver\result
 */
class FileResult
{

    /**
     * @var \cloak\value\Path
     */
    private $path;

    /**
     * @var array
     */
    private $resultLines;


    /**
     * @param string $path
     * @param array $resultLines
     * @throws \cloak\driver\result\FileNotFoundException
     */
    public function __construct($path, $resultLines = [])
    {
        $absolutePath = Path::fromString($path);

        if (file_exists($absolutePath) === false) {
            throw new FileNotFoundException("'$path' file does not exist");
        }
        $this->path = $absolutePath;
        $this->resultLines = $resultLines;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return (string) $this->path;
    }

    /**
     * @return array
     */
    public function getLineResults()
    {
        return $this->resultLines;
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

    /**
     * @param array $paths
     * @return bool
     */
    public function matchPaths(array $paths)
    {
        foreach ($paths as $path) {
            if ($this->matchPath($path) === false) {
                continue;
            }
            return true;
        }

        return false;
    }

}
