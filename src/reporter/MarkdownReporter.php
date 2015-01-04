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
use cloak\writer\FileWriter;
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;
use cloak\result\collection\CoverageResultCollection;
use cloak\value\Coverage;
use cloak\value\CoverageBound;


/**
 * Class MarkdownReporter
 * @package cloak\reporter
 */
class MarkdownReporter implements ReporterInterface
{

    use Reportable;

    const TABLE_SEPARATOR_CHAR = '|';

    const ALIGN_LEFT = ':--';
    const ALIGN_RIGTH = '--:';

    private $columnHeaders = [
        ' No. ',
        ' File ',
        ' Line ',
        ' Coverage '
    ];

    private $columnHeaderAlignments = [
        self::ALIGN_RIGTH,
        self::ALIGN_LEFT,
        self::ALIGN_RIGTH,
        self::ALIGN_RIGTH
    ];

    /**
     * @var CoverageBound
     */
    private $bounds;

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
    public function __construct (
        $outputFilePath,
        $satisfactory = self::DEFAULT_HIGH_BOUND,
        $critical = self::DEFAULT_LOW_BOUND
    )
    {
        $this->bounds = new CoverageBound($critical, $satisfactory);
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
        $files = $result->getFiles();

        $lowCoverage = $this->bounds->getLowCoverageBound();
        $criticalResults = $files->selectByCoverageLessThan($lowCoverage);

        $highCoverage = $this->bounds->getHighCoverageBound();
        $satisfactoryResults = $files->selectByCoverageGreaterEqual($highCoverage);

        $warningResults = $files->exclude($criticalResults)
            ->exclude($satisfactoryResults);

        $this->writeResultHeader('Critical');
        $this->writeFilesResultHeader();
        $this->writeFilesResult($criticalResults);

        $this->writeResultHeader('Warning');
        $this->writeFilesResultHeader();
        $this->writeFilesResult($warningResults);

        $this->writeResultHeader('Satisfactory');
        $this->writeFilesResultHeader();
        $this->writeFilesResult($satisfactoryResults);
    }

    private function writeResultHeader($title)
    {
        $this->reportWriter->writeLine('## ' . $title);
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
     * @param CoverageResultCollection $files
     */
    private function writeFilesResult(CoverageResultCollection $files)
    {
        $orderNumber = 1;

        foreach ($files as $key => $file) {
            $this->writeFileResult($orderNumber, $file);
            $orderNumber++;
        }

        $this->reportWriter->writeEOL();
    }

    /**
     * @param int $orderNumber
     * @param FileResult $file
     */
    private function writeFileResult($orderNumber, FileResult $file)
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

    /**
     * @param array $values
     * @return string
     */
    private function toTableRow(array $values)
    {
        $record = implode(static::TABLE_SEPARATOR_CHAR, $values);
        $record = static::TABLE_SEPARATOR_CHAR . $record . static::TABLE_SEPARATOR_CHAR;

        return $record;
    }

}
