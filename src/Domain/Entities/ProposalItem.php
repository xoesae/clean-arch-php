<?php

declare(strict_types=1);

namespace App\Domain\Entities;

final class ProposalItem
{
    public string $name;
    public int $value;

    public function __construct(string $name, int $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
