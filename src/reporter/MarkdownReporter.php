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
use cloak\result\File;
use cloak\writer\FileWriter;
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;
use PhpCollection\Sequence;


/**
 * Class MarkdownReporter
 * @package cloak\reporter
 */
class MarkdownReporter implements ReporterInterface
{

    use Reportable;

    const TABLE_SEPARATOR_CHAR = '|';

    const ALIGN_LEFT = ':-';
    const ALIGN_RIGTH = '-:';

    private $columnHeaders = [
        ' No. ',
        ' File ',
        ' Line ',
        ' Coverage '
    ];

    private $columnHeaderAlignments = [
        self::ALIGN_LEFT,
        self::ALIGN_LEFT,
        self::ALIGN_RIGTH,
        self::ALIGN_RIGTH
    ];

    /**
     * @var \cloak\writer\FileWriter
     */
    private $reportWriter;

    /**
     * @var \DateTime
     */
    private $generatedAt;


    /**
     * @param string $outputFilePath
     */
    public function __construct($outputFilePath)
    {
        $this->reportWriter = new FileWriter($outputFilePath);
    }

    /**
     * @param StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
        $this->generatedAt = $event->getSendAt();
    }

    /**
     * @param StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $this->writeMarkdownReport($event->getResult());
    }

    /**
     * @param Result $result
     */
    private function writeMarkdownReport(Result $result)
    {
        $this->writeTitle();
        $this->writeDescription();
        $this->writeResult($result);
    }

    private function writeTitle()
    {
        $this->reportWriter->writeLine('# Code Coverage Report');
        $this->reportWriter->writeEOL();
    }

    private function writeDescription()
    {
        $generatedDateTime = $this->generatedAt->format('j F Y \a\t H:i');

        $this->reportWriter->writeLine('Generator: cloak  ');
        $this->reportWriter->writeLine("Generated at: $generatedDateTime  ");
        $this->reportWriter->writeEOL();
    }

    private function writeResult(Result $result)
    {
        $this->writeResultHeader();
        $this->writeFilesResultHeader();
        $this->writeFilesResult($result->getFiles());
    }

    private function writeResultHeader()
    {
        $this->reportWriter->writeLine('## Result');
        $this->reportWriter->writeEOL();
    }

    private function writeFilesResultHeader()
    {
        $record = $this->toTableRow($this->columnHeaders);
        $this->reportWriter->writeLine($record);

        $record = $this->toTableRow($this->columnHeaderAlignments);
        $this->reportWriter->writeLine($record);
    }

    /**
     * @param Sequence $files
     */
    private function writeFilesResult(Sequence $files)
    {
        foreach ($files as $key => $file) {
            $orderNumber = $key + 1;
            $this->writeFileResult($orderNumber, $file);
        }
    }

    /**
     * @param int $orderNumber
     * @param File $file
     */
    private function writeFileResult($orderNumber, File $file)
    {

        $lineResult = sprintf("%2d/%2d",
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        );

        $coverageResult = sprintf('%6.2f%%', $file->getCodeCoverage()->value());

        $parts = [
            $orderNumber,
            $file->getRelativePath(getcwd()),
            $lineResult,
            $coverageResult
        ];

        $record = $this->toTableRow($parts);
        $this->reportWriter->writeLine($record);
    }

    private function toTableRow(array $values)
    {
        $record = implode(static::TABLE_SEPARATOR_CHAR, $values);
        $record = static::TABLE_SEPARATOR_CHAR . $record . static::TABLE_SEPARATOR_CHAR;

        return $record;
    }

}
