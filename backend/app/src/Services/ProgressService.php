<?php
namespace App\Services;

use App\Models\Progress;
use App\Repositories\IProgressRepository;
use App\Services\IProgressService;

class ProgressService implements IProgressService
{
    private IProgressRepository $progressRepository;

    public function __construct(IProgressRepository $progressRepository)
    {
        $this->progressRepository = $progressRepository;
    }
    
    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(int $userId): array
    {
        return $this->progressRepository->getProgressByUserId($userId);
    }

    // Methode die voortgang van alle studenten ophaalt
    public function getAllStudentsProgress(): array
    {
        return $this->progressRepository->getAllStudentsProgress();
    }
}