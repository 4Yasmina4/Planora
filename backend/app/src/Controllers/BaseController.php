<?php
namespace App\Controllers;

use App\Services\IAuthenticationService;
use App\Enums\UserRole;

class BaseController
{
    // Readonly zorgt ervoor dat de property na de constructor niet meer gewijzigd kan worden
    private readonly IAuthenticationService $authenticationService;

    // IAuthenticationService via dependency injection meegeven
    public function __construct(IAuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    // Methode om de user_id op te halen uit het JWT token in de Authorization header
    // Elk HTTP verzoek heeft headers - dit zijn extra stukjes informatie die meegestuurd worden
    // De Authorization header is speciaal bedoeld om authenticatie informatie mee te sturen
    // Wordt gebruikt in beveiligde controllers om de te controleren wie de ingelogde gebruiker is
    protected function getUserIdFromJwtRequest(): ?int 
    {
        // JWT token ophalen uit de Authorization header
        $jwtToken = $this->authenticationService->getJwtTokenFromAuthorizationHeader();

        // user_id ophalen uit het JWT token en teruggeven via de methode in de AuthenticationService
        return $this->authenticationService->getUserIdFromJwtToken($jwtToken);
    }

    // Methode om te controleren of de gebruiker ingelogd is op basis van het JWT token
    // Geeft een HTTP 401 (Unauthorized) foutmelding terug als de gebruiker niet ingelogd is
    protected function validateUserAuthentication(): ?int 
    {
        // user_id ophalen uit het JWT token via helpermehode in BaseController
        $userId = $this->getUserIdFromJwtRequest();

        // Als er geen geldige user_id is, is de gebruiker niet ingelogd
        if (!$userId)
        {
            // HTTP statuscode 401 (Unauthorized) teruggeven
            $this->jsonErrorResponse('Niet geautoriseerd', 401);
            return null;
        }

        // Bij een geldige user_id, user_id teruggsturen
        return $userId;

    } 

    // Methode om te controleren of gebruiker is geautoriseerd
    protected function isAuthenticatedUser(): bool 
    {
        // Ophalen van de user_id uit het JWT token
        $userId = $this->validateUserAuthentication();

        // Als user_id null is, is de gebruiker niet ingelogd
        if ($userId === null)
        {
            return false;
        }

        // Anders is de gebruiker wel ingelogd
        return true;
    }

    // Gedeelde helpermethode voor administrator en student om de gebruikersrol uit het JWT token op te halen
    private function getUserRoleFromJwtToken(): ?string 
    {
        // JWT token ophalen uit de Authorization header
        $jwtToken = $this->authenticationService->getJwtTokenFromAuthorizationHeader();

        // user_id uit token halen om te controleren of token geldig is
        $decodedUserId = $this->authenticationService->getUserIdFromJwtToken($jwtToken);

        // Als token ongeldig is, HTTP statuscode 401 geven
        if (!$decodedUserId)
        {
            $this->jsonErrorResponse('Niet geautoriseerd', 401);
            return null;
        }

        // Token opnieuw decoderen om de gebruikersrol op te halen
        try {
            // Volledig JWT payload decoderen om de gebruikersrol op te halen
            // Deze payload bevat onder andere user_id, naamgegevens, rol, iat en exp
            $payload = \Firebase\JWT\JWT::decode($jwtToken, new \Firebase\JWT\Key(getenv('JWT_SECRET_KEY'), 'HS256'));
        } catch (\Exception $e)
        {
            $this->jsonErrorResponse('Niet geautoriseerd', 401);
            return null;
        }

        // Gebruikersrol uit het JWT payload teruggeven
        return $payload->role;
    }

    // Methode om te controleren of de gebruiker een administrator is
    protected function validateUserIsAdministrator(): bool 
    {
        // Gebruikersrol uit JWT token halen via helpermethode
        $userRole = $this->getUserRoleFromJwtToken();

        if ($userRole == null)
        {
            return false;
        }

        // Alleen administrators hebben toegang
        if ($userRole !== UserRole::ADMINISTRATOR->value)
        {
            $this->jsonErrorResponse('Geen toegang: alleen administrators mogen deze actie uitvoeren.', 403);
            return false;
        }

        return true;
    }

    // Methode om te controleren of de gebruiker een student is
    protected function validateUserIsStudent(): bool 
    {
        // Gebruikersrol uit JWT token halen via helpermethode
        $userRole = $this->getUserRoleFromJwtToken();

        if ($userRole == null)
        {
            return false;
        }

        // Alleen student heeft toegang
        if ($userRole !== UserRole::STUDENT->value)
        {
            $this->jsonErrorResponse('Geen toegang: alleen studenten mogen deze actie uitvoeren.', 403);
            return false;
        }

        return true;
    }

    // Een success JSON response terugsturen naar de frontend
    // Er wordt een HTTP statuscode 200 (OK) gegeven; Verzoek is gelukt, data wordt teruggestuurd naar frontend
    // Er wordt een array of object van data teruggegeven
    protected function jsonSuccessResponse(array|object $data, int $httpStatusCode = 200): void 
    {
        // HTTP statuscode instellen (200 in dit geval) die wordt meegestuurd naar de frontend
        http_response_code($httpStatusCode);

        // Aangeven dat de response JSON data bevat
        header('Content-Type: application/json');

        // Zet PHP data om naar JSON formaat en stuurt het daarna met echo naar de frontend
        echo json_encode($data);
    }

    
    // Een error JSON response terugsturen naar de frontend
    // Er wordt een HTTP statuscode 400 (Bad Request) gegeven; Verkeerde of ontbrekende data is meegestuurd
    // Er wordt een string teruggegeven
    protected function jsonErrorResponse(string $errorMessage, int $httpStatusCode = 400): void 
    {
        // HTTP statuscode instellen (400 in dit geval) die wordt meegestuurd naar de frontend
        http_response_code($httpStatusCode);

        // Aangeven dat de response JSON data bevat
        header('Content-Type: application/json');

        // De foutmelding in een array met een 'error' key wikkelen
        // Frontend kan hierdoor altijd op dezelfde plek de foutmelding vinden
        // De array wordt omgezet naar JSON formaat en wordt naar de frontend gestuurd
        echo json_encode(['error' => $errorMessage]);
    }

    // JSON data ophalen uit de request body die de frontend meestuurt
    // De request body is de data die meegestuurd wordt in het verzoek van de frontend naar de backend
    // Kan null teruggeven als er geen data wordt meegestuurd
    protected function getJsonDataFromRequestBody(): ?array
    {
        // Ruwe JSON string uit de request body lezen via php://input
        // Zet deze om naar een PHP associatieve array via json_decode
        // 'true' als tweede parameter zorgt ervoor dat het resultaat een associatieve array wordt in plaats van een object
        return json_decode(file_get_contents('php://input'), true);
    }

    // Controleren of alle verplichte invoervelden ingevuld zijn in de request data 
    // True teruggeven als alle verplichte invoervelden zijn ingevuld, false als niet alle verplichte invoervelden ingevuld zijn
    protected function validateRequiredFormFields(array $formData, array $requiredFormFields): bool 
    {
        // Voor elk invoerveld van een formulier geldt:
        foreach ($requiredFormFields as $formField)
        {
            if (empty($formData[$formField]))
            {
                // False; niet alle verplichte invoervelden zijn ingevuld
                return false;
            }
        }

        // True; alle verplichte invoervelden zijn ingevuld
        return true;
    }

    // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
    // $vars is een array die door FastRoute wordt aangemaakt op basis van de URL
    // Bijvoorbeeld: /users/5 → $vars = ['id' => 5] → geeft 5 terug als integer 
    protected function getIdFromUrlParameters(array $vars): int
    {
        return (int)$vars['id'];
    }
}