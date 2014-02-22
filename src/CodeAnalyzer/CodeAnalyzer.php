<?php

namespace CodeAnalyzer;

class CodeAnalyzer
{

    public static function configure(\Closure $configurator)
    {
        $configurator(new Configuration());
    }

}
