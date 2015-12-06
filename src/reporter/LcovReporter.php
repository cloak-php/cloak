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


use cloak\AnalyzedCoverageResult;
use cloak\result\FileResult;
use cloak\analyzer\result\LineResult;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\event\FinalizeEvent;
use cloak\writer\FileWriter;
use PHPExtra\EventManager\EventManagerInterface;


/**
 * Class LcovReporter
 * @package cloak\reporter
 */
class LcovReporter
    implements Reporter, InitializeEventListener, FinalizeEventListener, AnalyzeStopEventListener
{

    const SOURCE_FILE_PREFIX = 'SF:';
    const COVERAGE_PREFIX = 'DA:';
    const END_OF_RECORD = 'end_of_record';

    /**
     * @var string Report file name
     */
    private $fileName;


    /**
     * @var \cloak\writer\FileWriter
     */
    private $reportWriter;


    /**
     * @param string|null $fileName
     * @throws \cloak\writer\DirectoryNotFoundException
     * @throws \cloak\writer\DirectoryNotWritableException
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param InitializeEvent $event
     */
    public function onInitialize(InitializeEvent $event)
    {
        $reportDirectory = $event->getReportDirectory();
        $reportFile = $reportDirectory->join($this->fileName);

        $this->reportWriter = new FileWriter( $reportFile->stringify() );
    }

    /**
     * @param \cloak\event\AnalyzeStopEvent $event
     */
    public function onAnalyzeStop(AnalyzeStopEvent $event)
    {
        $result = $event->getResult();
        $this->writeResult($result);
    }

    /**
     * @param FinalizeEvent $event
     */
    public function onFinalize(FinalizeEvent $event)
    {
        $this->reportWriter = null;
    }

    /**
     * @param AnalyzedCoverageResult $result
     */
    private function writeResult(AnalyzedCoverageResult $result)
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
     * @param \cloak\analyzer\result\LineResult $line
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

    /**
     * @param EventManagerInterface $eventManager
     */
    public function registerTo(EventManagerInterface $eventManager)
    {
        $eventManager->addListener($this);
    }

}
