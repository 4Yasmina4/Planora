<?php
namespace App\Services;

interface IAuthenticationService
{
    // Methode om de user_id uit het JWT token te halen
    public function getUserIdFromJwtToken(string $jWtToken): ?int;
    
    // Methode om het JWT token uit de Authorization header te halen
    public function getJwtTokenFromAuthorizationHeader(): ?string;

    // Methode om in te loggen en een JWT token terug te geven
    public function login(string $email, string $password): ?string;

    // Methode om te controleren of een e-mailadres al bestaat
    public function emailExists(string $email): bool;    
}