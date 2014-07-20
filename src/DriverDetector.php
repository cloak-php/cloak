<?php

/**
 * This file is part of easycoverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage;

use easycoverage\Driver\DriverNotAvailableException;

/**
 * Class DriverDetector
 * @package easycoverage
 */
class DriverDetector implements DriverDetectorInterface
{

    /**
     * @var array
     */
    private $drivers;

    /**
     * @param array $drivers
     */
    public function __construct(array $drivers)
    {
        $this->drivers = $drivers;
    }

    /**
     * @return \easycoverage\Driver\DriverInterface
     * @throws \easycoverage\DriverNotFoundException
     */
    public function detect()
    {
        $result = null;
        $exceptions = [];

        foreach ($this->drivers as $driver) {
            try {
                $result = new $driver();
            } catch (DriverNotAvailableException $exception) {
                $exceptions[] = $exception->getMessage();
            }
        }

        if (count($exceptions) === count($this->drivers)) {
            throw new DriverNotFoundException($exceptions);
        }

        return $result;
    }

}
