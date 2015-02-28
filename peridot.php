<?php

use Evenement\EventEmitterInterface;
use Peridot\Reporter\Dot\DotReporterPlugin;
use expectation\peridot\ExpectationPlugin;

return function(EventEmitterInterface $emitter)
{
    ExpectationPlugin::create()->registerTo($emitter);
    new DotReporterPlugin($emitter);
};
