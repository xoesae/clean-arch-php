<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\ProposalStatus;
use DateTime;

final class Proposal
{
    public string $description;
    public ProposalStatus $status;
    public int $value;
    /**
     * @var array<ProposalItem>
     */
    public array $items;
    public DateTime $expiresAt;
    public DateTime $createdAt;

    /**
     * @param string $description
     * @param ProposalStatus $status
     * @param int $value
     * @param array<ProposalItem> $items
     * @param DateTime $expiresAt
     * @param DateTime $createdAt
     */
    public function __construct(
        string $description,
        ProposalStatus $status,
        int $value,
        array $items,
        DateTime $expiresAt,
        DateTime $createdAt
    ) {
        $this->description = $description;
        $this->status = $status;
        $this->value = $value;
        $this->items = $items;
        $this->expiresAt = $expiresAt;
        $this->createdAt = $createdAt;
    }
}
