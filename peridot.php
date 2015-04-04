<?php

use Evenement\EventEmitterInterface;
use expect\peridot\ExpectPlugin;
use holyshared\peridot\temporary\TemporaryPlugin;
use Peridot\Reporter\Dot\DotReporterPlugin;

return function(EventEmitterInterface $emitter)
{
    ExpectPlugin::create()->registerTo($emitter);
    TemporaryPlugin::create()->registerTo($emitter);
    (new DotReporterPlugin($emitter));
};
