<?php
namespace App\Repositories;

use App\Models\Progress;

interface IProgressRepository
{
    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(int $userId): array;
}