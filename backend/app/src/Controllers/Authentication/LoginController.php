<?php
namespace App\Controllers\Authentication;

use App\Controllers\BaseController;
use App\Services\UserService;

class LoginController extends BaseController
{
    private UserService $userService;

    // UserService via dependency injection meegeven.
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Methode om in te loggen
    public function login(): void 
    {
        // LoginData ophalen uit de request body via methode getJsonDataFromRequestBody in BaseController
        $loginData = $this->getJsonDataFromRequestBody();

        // E-mailadres en wachtwoord valideren die ingevuld moeten zijn tijden het inloggen
        $requiredLoginData = $this->validateRequiredFormFields($loginData, ['email', 'password']);
        if (!$requiredLoginData)
        {
            // Als een van de velden niet ingevuld zijn, foutmelding geven
            $this->jsonErrorResponse('E-mailadres en wachtwoord zijn verplicht.');
            return;
        }

        // Login methode aanroepen van de UserService met email en wachtwoord
        $token = $this->userService->login($loginData['email'], $loginData['password']);

        // Als de token null is, zijn de inloggegevens onjuist
        if (!$token)
        {
            // HTTP statuscode 401 (Unauthorized) meegeven
            $this->jsonErrorResponse('Onjuist e-mailadres of wachtwoord', 401);
            return;
        }

        // JWT token (JSON Web Token) terugsturen naar de frontend
        $this->jsonSuccessResponse(['token' => $token]);
    }
}