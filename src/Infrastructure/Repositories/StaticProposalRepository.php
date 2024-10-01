<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Proposal;
use App\Domain\Entities\ProposalItem;
use App\Domain\Enums\ProposalStatus;
use App\Domain\Repositories\ProposalRepository;
use DateTime;

class StaticProposalRepository implements ProposalRepository
{
    public function getFinancialReport(ProposalStatus $status, DateTime $startDate, DateTime $endDate): iterable
    {
        for ($i = 0; $i < 1000; $i++) {
            $items = [new ProposalItem('Item ' . $i, 99999)];
            yield (new Proposal('Short description', $status, 99999, $items, new DateTime(), new DateTime()));
        }
    }
}
