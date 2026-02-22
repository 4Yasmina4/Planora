<?php
namespace App\Repositories;

use PDO;
use App\Models\User;
use App\Enums\UserRole;

class UserRepository
{
    private PDO $pdo;

    //Constructor die $pdo opslaat
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}