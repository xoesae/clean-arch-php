<?php

declare(strict_types=1);

namespace App\Application\UseCases\Reports;

use App\Application\Contracts\Storage;
use App\Domain\Entities\Proposal;
use App\Domain\Enums\ProposalStatus;
use App\Domain\Reports\FinancialReportBuilder;
use App\Domain\Repositories\ProposalRepository;
use DateMalformedStringException;
use DateTime;

final readonly class GenerateFinancialReportUseCase
{
    public function __construct(
        private ProposalRepository $proposalRepository,
        private FinancialReportBuilder $reportBuilder,
        private Storage $storage,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function __invoke(string $filename, string $path, string $status, string $startDate, string $endDate): string
    {
        $status = ProposalStatus::from($status);
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        /** @var iterable<Proposal> $proposals */
        $proposals = $this->proposalRepository->getFinancialReport($status, $startDate, $endDate);

        $this->reportBuilder->addHeader("Description", "Status", "Value", "Created At");

        foreach ($proposals as $proposal) {
            $value = number_format($proposal->value / 100, 2, ',', '.');
            $this->reportBuilder->addRow($proposal->description, $proposal->status->value, $value, $proposal->createdAt->format('Y-m-d'));
        }

        $content =  $this->reportBuilder->build();
        $extension = $this->reportBuilder->getExtension();
        $fullFilename = $filename . $extension;
        $this->storage->store($fullFilename, $path, $content);

        return "$path/$fullFilename";
    }
}
