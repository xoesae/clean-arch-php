<?php

namespace App\Domain\Reports;

interface FinancialReportBuilder
{
    public function addHeader(string ...$cells): void;
    public function addRow(string ...$cells): void;
    public function build(): string;
    public function getExtension(): string;
}
