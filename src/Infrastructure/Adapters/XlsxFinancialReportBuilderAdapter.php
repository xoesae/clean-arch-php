<?php

namespace App\Infrastructure\Adapters;

use App\Application\Exceptions\Storage\UnableToOpenFileException;
use App\Domain\Reports\FinancialReportBuilder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class XlsxFinancialReportBuilderAdapter implements FinancialReportBuilder
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

    public function build(): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($this->header);

        foreach ($this->body as $index => $row) {
            $sheet->fromArray($row, null, "A" . $index+2);
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        return ob_get_clean();
    }

    public function getExtension(): string
    {
        return '.xlsx';
    }
}