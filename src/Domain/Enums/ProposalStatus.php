<?php

declare(strict_types=1);

namespace App\Domain\Enums;

enum ProposalStatus: string
{
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case WAITING = 'WAITING';
}
