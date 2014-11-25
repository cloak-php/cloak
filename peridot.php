<?php

use Evenement\EventEmitterInterface;
use expectation\peridot\ExpectationPlugin;

return function(EventEmitterInterface $emitter)
{
    ExpectationPlugin::create()->registerTo($emitter);
};
