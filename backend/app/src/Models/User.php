<?php
namespace App\Models;

use App\Enums\UserRole;

class User {
    //Private attributen voor veiligheidsredenen
    private int $userId;
    private string $firstName;
    private ?string $surnamePrefix; //null toegestaan
    private string $lastName;
    private string $email;
    private string $password;
    private UserRole $userRole;


    public function __construct(int $userId, string $firstName, ?string $surnamePrefix, string $lastName, string $email, string $password, UserRole $userRole)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->surnamePrefix = $surnamePrefix;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->userRole = $userRole;
    }

    //Getters
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getSurnamePrefix(): ?string
    {
        return $this->surnamePrefix;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserRole(): UserRole
    {
        return $this->userRole;
    }
}