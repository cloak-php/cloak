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

use cloak\result\File;
use PhpCollection\Sequence;
use PhpCollection\AbstractSequence;

/**
 * Class Result
 * @package cloak
 */
class Result
{

    private $files = null;

    public function __construct(AbstractSequence $files = null)
    {
        if (is_null($files)) {
            $this->files = new Sequence();
        } else {
            $this->files = $files;
        }
    }

    public static function from(array $result)
    {
        $files = static::parseResult($result);

        return new self($files);
    }

    public static function parseResult(array $result)
    {
        $files = new Sequence(); 

        foreach ($result as $path => $lines) {
            if (file_exists($path) === false) {
                continue;
            }
            $files->add(new File($path, $lines));
        }

        return $files;
    }

    public function includeFile(\Closure $filter)
    {
        $files = $this->files->filter($filter);
        return new self($files);
    }

    public function includeFiles(array $filters)
    {
        $files = $this->files;

        foreach ($filters as $filter) {
            $files = $files->filter($filter);
        }

        return new self($files);
    }

    public function excludeFile(\Closure $filter)
    {
        $files = $this->files->filterNot($filter);
        return new self($files);
    }

    public function excludeFiles(array $filters)
    {
        $files = $this->files;

        foreach ($filters as $filter) {
            $files = $files->filterNot($filter);
        }

        return new self($files);
    }

    public function setFiles(AbstractSequence $files)
    {
        $this->files = $files;
        return $this;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function addFile(File $file)
    {
        $this->files->add($file);
        return $this;
    }

    public function removeFile(File $file)
    {
        $indexAt = $this->files->indexOf($file);

        if ($indexAt === -1) {
            return $this;
        }
        $this->files->remove($indexAt);

        return $this;
    }

}
