<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer;

use CodeAnalyzer\Driver\DriverNotAvailableException;

/**
 * Class DriverDetector
 * @package CodeAnalyzer
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
     * @return \CodeAnalyzer\Driver\DriverInterface
     * @throws \CodeAnalyzer\DriverNotFoundException
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

        if (!empty($exceptions)) {
            throw new DriverNotFoundException($exceptions);
        }

        return $result;
    }

}
