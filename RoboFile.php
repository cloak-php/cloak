<?php

use \Robo\Tasks;

/**
 * Class RoboFile
 */
class RoboFile extends Tasks
{

    public function specAll()
    {
        $peridot = 'vendor/bin/peridot';
        $peridotSpecDirectory = 'spec';

        return $this->taskExec($peridot . ' ' . $peridotSpecDirectory)->run();
    }

    public function specCoverage()
    {
        $peridot = 'vendor/bin/peridot';
        $configurationFileOption = '--configuration peridot.coverage.php';

        return $this->taskExec($peridot . ' ' . $configurationFileOption)->run();
    }

}
