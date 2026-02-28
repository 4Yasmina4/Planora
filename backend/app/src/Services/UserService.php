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

    // Methode om alle gebruikers op te halen
    public function getAllUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }

    // Methode om één gebruiker op te halen op basis van userId
    public function getUserByUserId(int $userId): ?User
    {
        return $this->userRepository->getUserByUserId($userId);
    }

    // Methode om een nieuwe gebruiker aan te maken
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

    // Methode om gebruikergegevens te wijzigen
    // Op basis van de userId worden de gegevens van een gebruiker gewijzigd
    public function updateUser(int $userId, string $firstName, ?string $surnamePrefix, string $lastName, string $email, ?string $password, string $role): User
    {
        // String $role omzetten naar UserRole enum via de private methode convertStringToUserRoleEnum
        $userRole = $this->convertStringToUserRoleEnum($role);

        // Wachtwoord alleen wijzigen en hashen als er een nieuwe wachtwoord in het formulierveld is ingevuld
        $hashedPassword = null;

        if (!empty($password))
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        // UserRepository aanroepen om gegevens van een gebruiker te wijzigen
        return $this->userRepository->updateUser($userId, $firstName, $surnamePrefix, $lastName, $email, $hashedPassword, $userRole);
    }

    // Methode om een gebruiker te verwijderen op basis van de user_id
    // Deze methode geeft een bool terug, omdat na het verwijderen van een gebruiker het handig is om te weten of dit is gelukt
    // Hierbij is het onnodig om een User-object terug te geven
    public function deleteUser(int $userId): bool
    {
        //UserRepository aanroepen om een gebruiker te verwijderen
        return $this->userRepository->deleteUser($userId);
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