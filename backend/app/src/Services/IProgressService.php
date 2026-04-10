<?php
namespace App\Services;

use App\Models\Progress;

interface IProgressService
{
    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(int $userId): array;
}