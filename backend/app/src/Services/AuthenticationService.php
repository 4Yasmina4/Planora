<?php
namespace App\Services;

use App\Repositories\IUserRepository;
use App\Services\IAuthenticationService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationService implements IAuthenticationService
{
    // Geheime sleutel voor het ondertekenen van de JWT token
    // Voorkomt dat iemand de token kan namaken of aanpassen
    private string $secretJwtKey;
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->secretJwtKey = getenv('JWT_SECRET_KEY');
    }

    // Methode om de user_id uit het JWT token (JSON Web Token ) te halen
    // ?int als return type geven bij een ongeldige token
    public function getUserIdFromJwtToken(string $jwtToken): ?int 
    {
        try{
            // int teruggeven als het JWT token geldig is en een user_id bevat
            // HS256, hiermee wordt het token ondertekend
            // Het zorgt ervoor dat niemand het token kan namaken of aanpassen zonder de geheime sleutel
            // JWT token decoderen naar een PHP object met de token inhoud 
            // (user_id, role van gebruiker, iat (Issued At - tijdstip waarop token is aangemaakt), exp (Expiration - tijdstip waarop token is verlopen))
            $decodedJwtToken = JWT::decode($jwtToken, new Key($this->secretJwtKey, 'HS256'));
            return (int)$decodedJwtToken->user_id;
        } catch (\Exception $e) {
            // Als het JWT token ongeldig is of er is geen token aanwezig, null teruggeven
            return null;
        }
    }

    // Methode om het JWT token uit de Authorization header te halen
    // Elk HTTP verzoek heeft headers - dit zijn extra stukjes informatie die meegestuurd worden
    // De Authorization header is speciaal bedoeld om authenticatie informatie mee te sturen
    public function getJwtTokenFromAuthorizationHeader(): ?string 
    {
        // Authorization header ophalen via $_SERVER
        // $_SERVER is betrouwbaarder dan getallheaders()
        if (isset($_SERVER['HTTP_AUTHORIZATION']))
        {
            $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return null;
        }

        // Het woord 'Bearer ' verwijderen, zodat alleen het JWT token overblijft
        // 'Bearer' is de officiële standaard voor JWT tokens
        // De naam betekent dat de drager (bearer) van het token toegang krijgt
        return str_replace('Bearer ', '', $authorizationHeader);
    }

    // Methode dat het ingevoerde email en wachtwoord controleert tijdens het inloggen
    // Geeft een JWT token terug als het inloggen is gelukt
    public function login(string $email, string $password): ?string
    {
        // Gebruiker ophalen op basis van het ingevoerde e-mailadres via de UserRepository
        $user = $this->userRepository->getUserByEmail($email);

        // Als gebruiker niet bestaat, null teruggeven
        if (!$user)
        {
            return null;
        }

        // Ingevoerde wachtwoord controleren met het gehaste wachtwoord in de database
        // password_verify vergelijkt het ingevoerde wachtwoord met het gehaste wachtwoord
        if (!password_verify($password, $user->getPassword()))
        {
            return null;
        }

        // JWT token (JSON Web Token) aanmaken met gebruikersgegevens
        // $payload is de inhoud van de token
        $payload = [
            'user_id' => $user->getUserId(),
            'first_name' => $user->getFirstName(),
            'surname_prefix' => $user->getSurnamePrefix(),
            'last_name' => $user->getLastName(),
            'role' => $user->getUserRole()->value,
            'iat' => time(), // (iat = Issued At) datum waarop token is aangemaakt
            'exp' => time() + 3600 // verloopt na 1 uur
        ];

        // JWT token (JSON Web Token) genereren en teruggeven
        return JWT::encode($payload, $this->secretJwtKey, 'HS256');
    }


    // Methode om te controleren of een e-mailadres al bestaat
    public function emailExists(string $email): bool
    {
        // Gebruiker met bijbehornde e-mailadres ophalen
        $user = $this->userRepository->getUserByEmail($email);

        // Als gebruiker niet bestaat, false teruggeven
        if ($user === null)
        {
            return false;
        }

        // Als gebruiker wel bestaat, true teruggeven
        return true;
    }
}