<?php

use Evenement\EventEmitterInterface;
use Peridot\Reporter\Dot\DotReporterPlugin;
use expectation\peridot\ExpectationPlugin;
use holyshared\peridot\temporary\TemporaryPlugin;

return function(EventEmitterInterface $emitter)
{
    ExpectationPlugin::create()->registerTo($emitter);
    TemporaryPlugin::create()->registerTo($emitter);
    (new DotReporterPlugin($emitter));
};
