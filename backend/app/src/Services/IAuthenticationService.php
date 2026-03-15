<?php
namespace App\Services;

interface IAuthenticationService
{
    // Methode om de user_id uit het JWT token te halen
    public function getUserIdFromJwtToken(string $jWtToken): ?int;
    
    // Methode om het JWT token uit de Authorization header te halen
    public function getJwtTokenFromAuthorizationHeader(): ?string;
    
}