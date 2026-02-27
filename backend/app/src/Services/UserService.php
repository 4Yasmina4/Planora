<?php
namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Alle gebruikers ophalen
    public function getAllUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }

    // Één gebruiker ophalen op basis van userId
    public function getUserByUserId(int $userId): ?User
    {
        return $this->userRepository->getUserByUserId($userId);
    }

    // Nieuwe gebruiker aanmaken
    public function createUser(string $firstName, ?string $surnamePrefix, string $lastName, string $email, string $password, string $role): User
    {
        // String $role omzetten naar UserRole enum via de private methode convertStringToUserRoleEnum
        $userRole = $this->convertStringToUserRoleEnum($role);

        //Wachtwoord hashen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //User-object bouwen met behulp van helpermethode
        //Hashed wachtwoord wordt hierbij meegegeven in plaats van het gewone wachtwoord
        $user = $this->buildUser($firstName, $surnamePrefix, $lastName, $email, $hashedPassword, $userRole);

        //UserRepository aanroepen om een nieuwe gebruiker aan te maken
        return $this->userRepository->createUser($user);
    }

    // Helpermethodes //

    private function buildUser(string $firstName, ?string $surnamePrefix, string $lastName, string $email, string $hashedPassword, UserRole $userRole): User
    {
        // Null teruggeven voor user_id, omdat database deze genereert voor een nieuwe User
        return new User(null, $firstName, $surnamePrefix, $lastName, $email, $hashedPassword, $userRole);
    }

    // Methode om string $role om te zetten naar enum UserRole
    private function convertStringToUserRoleEnum(string $role): UserRole 
    {
        // String $role proberen om te zetten naar UserRole enum via tryFrom
        // Als de string $role niet overeenkomt met een geldige UserRole waarde geeft tryFrom null terug
        $userRole = UserRole::tryFrom($role);
        if ($userRole === null)
        {
            throw new \InvalidArgumentException('Ongeldige gebruikersrol: ' . $role);
        }

        return $userRole;
    }
}