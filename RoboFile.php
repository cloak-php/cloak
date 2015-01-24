<?php

use \Robo\Tasks;
use \coverallskit\robo\loadTasks as CoverallsKitTasks;
use \peridot\robo\loadTasks as PeridotTasks;


/**
 * Class RoboFile
 */
class RoboFile extends Tasks
{

    use PeridotTasks;
    use CoverallsKitTasks;

    public function specAll()
    {
        $result = $this->taskPeridot()
            ->directoryPath('spec')
            ->bail()
            ->run();

        return $result;
    }

    public function specCoverage()
    {
        $result = $this->taskPeridot()
            ->configuration('peridot.coverage.php')
            ->directoryPath('spec')
            ->bail()
            ->run();

        return $result;
    }

    public function coverallsUpload()
    {
        $result = $this->taskCoverallsKit()
            ->configureBy('coveralls.toml')
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
