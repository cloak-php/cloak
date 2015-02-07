<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;


use cloak\Result;
use cloak\result\FileResult;
use cloak\result\LineResult;
use cloak\event\StopEvent;
use cloak\writer\FileWriter;


/**
 * Class LcovReporter
 * @package cloak\reporter
 */
class LcovReporter implements ReporterInterface, StopEventListener
{

    const SOURCE_FILE_PREFIX = 'SF:';
    const COVERAGE_PREFIX = 'DA:';
    const END_OF_RECORD = 'end_of_record';

    use Reportable;

    /**
     * @var \cloak\writer\FileWriter
     */
    private $reportWriter;


    /**
     * @param string|null $outputFilePath
     * @throws \cloak\writer\DirectoryNotFoundException
     * @throws \cloak\writer\DirectoryNotWritableException
     */
    public function __construct($outputFilePath)
    {
        $this->reportWriter = new FileWriter($outputFilePath);
    }

    /**
     * @param \cloak\event\StopEvent $event
     */
    public function onStop(StopEvent $event)
    {
        $result = $event->getResult();
        $this->writeResult($result);
    }

    /**
     * @param Result $result
     */
    private function writeResult(Result $result)
    {
        $files = $result->getFiles();

        foreach($files as $file) {
            $this->writeFileResult($file);
        }
    }

    /**
     * @param FileResult $file
     */
    private function writeFileResult(FileResult $file)
    {
        $this->writeFileHeader($file);

        $targetLines = $this->getTargetLinesFromFile($file);

        foreach ($targetLines as $targetLine) {
            $this->writeLineResult($targetLine);
        }

        $this->writeFileFooter();
    }

    /**
     * @param FileResult $file
     */
    private function writeFileHeader(FileResult $file)
    {
        $parts = [
            self::SOURCE_FILE_PREFIX,
            $file->getPath()
        ];

        $record = implode('', $parts);
        $this->reportWriter->writeLine($record);
    }

    private function writeFileFooter()
    {
        $this->reportWriter->writeLine(self::END_OF_RECORD);
    }

    /**
     * @param \cloak\result\LineResult $line
     */
    private function writeLineResult(LineResult $line)
    {

        $executedCount = $line->isExecuted() ? 1 : 0;
        $recordParts = [
            $line->getLineNumber(),
            $executedCount
        ];

        $record = self::COVERAGE_PREFIX . implode(',', $recordParts);
        $this->reportWriter->writeLine($record);
    }

    /**
     * @param FileResult $file
     * @return array
     */
    private function getTargetLinesFromFile(FileResult $file)
    {
        $lineResults = $file->getLineResults();

        $results = $lineResults->selectLines(function(LineResult $line) {
            return $line->isExecuted() || $line->isUnused();
        })->all();

        return $results;
    }

}
