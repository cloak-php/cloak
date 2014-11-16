<?php

use \Robo\Tasks;
use \coverallskit\Configuration;
use \coverallskit\ReportBuilder;


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

    public function specCoveralls()
    {
        $configuration = Configuration::loadFromFile('.coveralls.yml');
        $builder = ReportBuilder::fromConfiguration($configuration);
        $builder->build()->save()->upload();
    }

}
