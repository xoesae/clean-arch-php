<?php

declare(strict_types=1);

use App\Application\Contracts\Storage;
use App\Domain\Reports\FinancialReportBuilder;
use App\Domain\Repositories\ProposalRepository;
use App\Infrastructure\Adapters\CsvFinancialReportBuilderAdapter;
use App\Infrastructure\Adapters\XlsxFinancialReportBuilderAdapter;
use App\Infrastructure\Adapters\LocalStorageAdapter;
use App\Infrastructure\Repositories\StaticProposalRepository;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
//    FinancialReportBuilder::class => DI\create(CsvFinancialReportBuilderAdapter::class),
    FinancialReportBuilder::class => DI\create(XlsxFinancialReportBuilderAdapter::class),
    ProposalRepository::class => DI\create(StaticProposalRepository::class),
    Storage::class => DI\create(LocalStorageAdapter::class),
]);

return $containerBuilder->build();