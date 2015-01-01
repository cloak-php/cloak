<?php

use \Robo\Tasks;
use \coverallskit\robo\CoverallsKitTasks;


/**
 * Class RoboFile
 */
class RoboFile extends Tasks
{

    use CoverallsKitTasks;

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

    public function coverallsUpload()
    {
        $result = $this->taskCoverallsKit()
            ->configure('coveralls.toml')
            ->run();

        return $result;
    }

    public function exampleBasic()
    {
        $php = 'php';
        $exampleScript = 'example/basic_example.php';

        return $this->taskExec($php . ' ' . $exampleScript)->run();
    }

}
