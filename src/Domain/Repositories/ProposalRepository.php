<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Proposal;
use App\Domain\Enums\ProposalStatus;
use DateTime;

interface ProposalRepository
{
    /**
     * @param ProposalStatus $status
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return iterable<Proposal>
     */
    public function getFinancialReport(ProposalStatus $status, DateTime $startDate, DateTime $endDate): iterable;
}
