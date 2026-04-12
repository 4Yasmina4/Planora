<?php
namespace App\Controllers\Authentication;

use App\Controllers\BaseController;
use App\Services\IUserService;
use App\Services\IAuthenticationService;

class AuthenticationController extends BaseController
{
    private IUserService $userService;
    private IAuthenticationService $authenticationService;

    public function __construct(IUserService $userService, IAuthenticationService $authenticationService)
    {
        $this->userService = $userService;
        $this->authenticationService = $authenticationService;
        // IAuthenticationService doorgeven aan de BaseController via parent constructor
        parent::__construct($authenticationService);
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

        // Login methode aanroepen van de IAuthenticationService met email en wachtwoord
        $token = $this->authenticationService->login($loginData['email'], $loginData['password']);

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

    // Methode om in te registreren
    public function register(): void 
    {
        // Userdata ophalen uit de request body via methode getJsonDataFromRequestBody in BaseController
        $userData = $this->getJsonDataFromRequestBody();

        // Userdata valideren; controleren of alle verplichten velden ingevuld zijn bij het aanmaken van een nieuwe gebruiker
        // Hierbij alleen attributen valideren die ingevuld moeten zijn
        $requiredUserData = $this->validateRequiredFormFields($userData, ['first_name', 'last_name', 'email', 'password']);
        if (!$requiredUserData)
        {
            // Als niet alle verplichte velden zijn ingevuld, foutmelding geven
            // Foutmelding met behulp van helpermethode in BaseController tonen
            $this->jsonErrorResponse('Voornaam, achternaam, email en wachtwoord zijn verplicht.');
            return;
        }

        // Controleren of het e-mailadres al bestaat
        if ($this->authenticationService->emailExists($userData['email']))
        {
            // Foutmelding tonen met HTTP statuscode 409 (Conflict)
            $this->jsonErrorResponse('Dit e-mailadres is al in gebruik.', 409);
            return;
        }

        // Nieuwe gebruiker aanmaken via de UserService methode createUser
        // Password meegeven en geen hashedPassword, omdat de Userservice het wachtwoord hasht
        // Gebruikersrol wordt automatisch op student
        $newUser = $this->userService->createUser($userData['first_name'], $userData['surname_prefix'] ?? null, $userData['last_name'], $userData['email'], $userData['password'], 'student');

        // Succesmelding tonen
        // HTTP statuscode 201 (Created) gebruiken; nieuw object succesvol aangemaakt
        $this->jsonSuccessResponse($newUser, 201);
    }
}