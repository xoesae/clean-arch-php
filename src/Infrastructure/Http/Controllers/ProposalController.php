<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\Reports\GenerateFinancialReportUseCase;
use App\Domain\Enums\ProposalStatus;
use DateMalformedStringException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

readonly class ProposalController
{
    public function __construct(
        private GenerateFinancialReportUseCase $generateFinancialReportUseCase,
    )
    {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function generateProposalReportCsv(ServerRequestInterface $request): JsonResponse
    {
        $useCase = $this->generateFinancialReportUseCase;
        $path = $useCase('report', __DIR__ . '/../../../../storage', ProposalStatus::APPROVED->value, '2024-01-01', '2024-01-01');
        return new JsonResponse(['path' => $path]);
    }
}