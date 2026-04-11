<?php
namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;

interface IUserService
{
    // Methode om alle gebruikers op te halen
    public function getAllUsers(): array;
    // Methode om één gebruiker op te halen op basis van de userId
    public function getUserByUserId(int $userId): ?User;
    // Methode om gebruiker op te halen op basis van hun email
    public function getUserByEmail(string $email): ?User;
    // Methode om gebruiker aan te maken
    public function createUser(string $firstName, ?string $surnamePrefix, string $lastName, string $email, string $password, string $role): User;
    // Methode om gebruikergegevens te wijzigen
    public function updateUser(int $userId, string $firstName, ?string $surnamePrefix, string $lastName, string $email, ?string $password, string $role): User;
    // Methode om een gebruiker te verwijderen op basis van de user_id
    // Deze methode geeft een bool terug, omdat na het verwijderen van een gebruiker het handig is om te weten of dit is gelukt
    public function deleteUser(int $userId): bool;
}