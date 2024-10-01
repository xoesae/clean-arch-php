<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters;

use App\Application\Exceptions\Storage\UnableToOpenFileException;
use App\Domain\Reports\FinancialReportBuilder;

class CsvFinancialReportBuilderAdapter implements FinancialReportBuilder
{
    /**
     * @var array<string>
     */
    private array $header = [];

    /**
     * @var array<array<string>>
     */
    private array $body = [];

    public function addHeader(string ...$cells): void
    {
        $this->header = $cells;
    }

    public function addRow(string ...$cells): void
    {
        $this->body[] = $cells;
    }

    /**
     * @throws UnableToOpenFileException
     */
    public function build(): string
    {
        $buffer = fopen('php://temp', 'r+');

        if ($buffer === false) {
            throw new UnableToOpenFileException('Unable to open temp file');
        }

        fputcsv($buffer, $this->header);

        foreach ($this->body as $row) {
            fputcsv($buffer, $row);
        }

        rewind($buffer);
        $content = stream_get_contents($buffer);
        fclose($buffer);

        if ($content === false) {
            throw new UnableToOpenFileException('Unable to open temp file');
        }

        return $content;
    }

    public function getExtension(): string
    {
        return '.csv';
    }
}
