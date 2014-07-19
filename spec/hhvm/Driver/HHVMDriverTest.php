<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Driver\HHVMDriver;
use \PHPUnit_Framework_TestCase;

//

//class HHVMDriverTest extends PHPUnit_Framework_TestCase
class HHVMDriverTest extends \mageekguy\atoum\test
{

    /**
     * @before
     */
    public function setUp()
    {
        $this->driver = new HHVMDriver();
    }

    /**
     * @test
     */
    public function testTakeCodeCoverage()
    {
        $this->assertFalse($this->driver->isStarted());

        $this->driver->start();
        $this->assertTrue($this->driver->isStarted());

        $this->driver->stop();
        $this->assertFalse($this->driver->isStarted());

        $result = $this->driver->getResult();
        $this->assertNotEmpty($result);
    }

}
