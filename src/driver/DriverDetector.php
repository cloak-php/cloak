<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver;

/**
 * Class DriverDetector
 * @package cloak\driver
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
     * @return \cloak\driver\DriverInterface
     * @throws \cloak\driver\DriverNotFoundException
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
