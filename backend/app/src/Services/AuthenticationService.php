<?php
namespace App\Services;

// use App\Repositories\IUserRepository;
use App\Repositories\UserRepository;
use App\Services\IAuthenticationService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationService implements IAuthenticationService
{
    private string $secretJwtKey;
    //private readonly IUserRepository $userRepository;
    private readonly UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
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
        // Alle headers ophalen uit het HTTP verzoek
        $headers = getallheaders();

        // Authorization header ophalen, null teruggeven als deze niet aanwezig is
        if (isset($headers['Authorization']))
        {
            $authorizationHeader = $headers['Authorization'];
        } else {
            return null;
        }

        // Het woord 'Bearer ' verwijderen, zodat alleen het JWT token overblijft
        // 'Bearer' is de officiële standaard voor JWT tokens
        // De naam betekent dat de drager (bearer) van het token toegang krijgt
        return str_replace('Bearer ', '', $authorizationHeader);
    }
}