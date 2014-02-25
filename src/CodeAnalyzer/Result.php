<?php

namespace CodeAnalyzer;

use \PhpCollection\Sequence;

class Result extends Sequence
{

    public static function from(array $result)
    {
        $files = static::parseResult($result);

        return new self($files->all());
    }

    public static function parseResult(array $result)
    {
        $files = new Sequence(); 

        foreach ($result as $path => $lines) {
            $files->add(new File($path, $lines));
        }

        return $files;
    }

    public function includeFile(\Closure $filter)
    {
        $files = $this->filter($filter);
        return $files;
    }

    public function excludeFile(\Closure $filter)
    {
        $files = $this->filterNot($filter);
        return $files;
    }

    public function addFile(File $file)
    {
        $this->add($file);
        return $this;
    }

    public function removeFile(File $file)
    {
        $indexAt = $this->indexOf($file);

        if ($indexAt === -1) {
            return $this;
        }
        $this->remove($indexAt);

        return $this;
    }

}
