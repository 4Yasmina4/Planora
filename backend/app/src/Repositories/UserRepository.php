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

    //Gebruiker aanmaken
    public function createUser(User $user): User
    {
        //SQL INSERT-query voorbereiden om een nieuwe gebruiker aan te maken
        $stmt = $this->pdo->prepare("
                INSERT INTO users (first_name, surname_prefix, last_name, email, password, role)
                VALUES (:first_name, :surname_prefix, :last_name, :email, :password, :role)
        ");

        //INSERT-query uitvoeren met de waarden uit het User-object
        $stmt->execute([
            'first_name' => $user->getFirstName(),
            'surname_prefix' => $user->getSurnamePrefix(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getUserRole()->value
        ]);

        //Database genereert een nieuwe user_id; deze wordt gebruikt om een volledige User-object terug te geven
        $userId = (int)$this->pdo->lastInsertId();

        //User-object aanmaken met nieuwe gegenereerde user_id via helpermethode
        return $this->mapUserWithUserId($user, $userId);
    }

    // Helpermethodes //
    // private //

    private function mapUserWithUserId(User $user, int $userId): User
    {
        return new User(
            $userId,
            $user->getFirstName(),
            $user->getSurnamePrefix(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getUserRole()
        );
    }

    // public //
    //Methode dat User-objecten aanmaakt van de opgehaalde database gegevens.
    public function mapRowToUser(array $row): User
    {
        return new User(
            $row['user_id'],
            $row['first_name'],
            $row['surname_prefix'],
            $row['last_name'],
            $row['email'],
            $row['password'],
            UserRole::from($row['role']),
        );
    }
}