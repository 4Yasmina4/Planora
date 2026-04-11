<?php
namespace App\Controllers\Administrator;

use App\Controllers\BaseController;
use App\Services\IUserService;
use App\Services\IAuthenticationService;

class UserManagementController extends BaseController
{
    private IUserService $userService;

    // IUserService via dependency injection meegeven.
    public function __construct(IUserService $userService, IAuthenticationService $authenticationService)
    {
        $this->userService = $userService;
        // IAuthenticationService doorgeven aan de BaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode om alle gebruikers op te halen
    public function getAllUsers(): void 
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }

        // Alle gebruikers ophalen
        $users = $this->userService->getAllUsers();

        // Lijst met gebruikers terugsturen naar de frontend
        $this->jsonSuccessResponse($users);
    }

    // Methode om één gebruiker op te halen
    public function getUserByUserId(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }

        // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
        // Dit via de helpermethode in de BaseController doen
        // $vars is een array die door FastRoute wordt aangemaakt op basis van de URL
        // Bijvoorbeeld: /users/5 → $vars = ['id' => 5] → geeft 5 terug als integer
        $userId = $this->getIdFromUrlParameters($vars);

        // Gebruiker ophalen via de UserService
        $user = $this->userService->getUserByUserId($userId);

        // Als de gberuiker niet bestaat → 404 (Not Found) teruggeven
        if (!$user)
        {
            $this->jsonErrorResponse('Gebruiker niet gevonden', 404);
            return;
        }

        // Gebruiker bestaat → JSON teruggeven
        $this->jsonSuccessResponse($user);
    }

    // Methode om een nieuwe gebruiker aan te maken
    public function createUser(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }

        // Userdata ophalen uit de request body via methode getJsonDataFromRequestBody in BaseController
        $userData = $this->getJsonDataFromRequestBody();
        
        // Userdata valideren; controleren of alle verplichten velden ingevuld zijn bij het aanmaken van een nieuwe gebruiker
        // Hierbij alleen attributen valideren die ingevuld moeten zijn
        $requiredUserData = $this->validateRequiredFormFields($userData, ['first_name', 'last_name', 'email', 'password', 'role']);
        if (!$requiredUserData)
        {
            // Als niet alle verplichte velden zijn ingevuld, foutmelding geven
            // Foutmelding met behulp van helpermethode in BaseController tonen
            $this->jsonErrorResponse('Voornaam, achternaam, email, wachtwoord en gebruikersrol zijn verplicht.');
            return;
        }

        // Nieuwe gebruiker aanmaken
        // Password meegeven en geen hashedPassword, omdat de Userservice het wachtwoord hasht
        $newUser = $this->userService->createUser($userData['first_name'], $userData['surname_prefix'] ?? null, $userData['last_name'], $userData['email'], $userData['password'], $userData['role']);

        // Succesmelding tonen
        // HTTP statuscode 201 (Created) gebruiken; nieuw object succesvol aangemaakt
        $this->jsonSuccessResponse($newUser, 201);
    }

    // Methode om gebruikergegevens te wijzigen
    // Op basis van de userId worden de gegevens van een gebruiker gewijzigd
    public function updateUser(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }

        // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
        // $vars is een array die door FastRoute wordt aangemaakt op basis van de URL
        $userId = $this->getIdFromUrlParameters($vars);

        // Controleren of gebruiker bestaat voordat deze wordt gewijzigd
        $user = $this->userService->getUserByUserId($userId);
        if (!$user)
        {
            // HTTP statuscode 404 (Not Found) meegeven
            $this->jsonErrorResponse('Gebruiker niet gevonden', 404);
            return;
        }

        // Gebruikersdata ophalen uit de request body
        $userData = $this->getJsonDataFromRequestBody();

        // Verplichte velden valideren (wachtwoord is hierbij optioneel)
        $requiredUserData = $this->validateRequiredFormFields($userData, ['first_name', 'last_name', 'email', 'role']);
        if (!$requiredUserData)
        {
            // Als niet alle verplichte velden zijn ingevuld, foutmelding tonen
            $this->jsonErrorResponse('Voornaam, achternaam, email en gebruikersrol zijn verplicht.');
            return;
        }

        // Gebruikersgegevens wijzigen
        $updatedUser = $this->userService->updateUser($userId, $userData['first_name'], $userData['surname_prefix'] ?? null, $userData['last_name'], $userData['email'], $userData['password'] ?? null, $userData['role']);

        // Gewijzigde gebruiker terugsturen naar de frontend
        $this->jsonSuccessResponse($updatedUser);
    }

    // Methode om gebruiker te verwijderen op basis van de user_id
    public function deleteUser(array $vars): void 
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }

        // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
        $userId = $this->getIdFromUrlParameters($vars);

        // Controleren of administrator zijn eigen account probeert te verwijderen
        $loggedInUserId = $this->getUserIdFromJwtRequest();
        if ($userId === $loggedInUserId)
        {
            // HTTP statuscode 403 (Forbidden) meegeven
            $this->jsonErrorResponse('Je kunt je eigen account niet verwijderen', 403);
            return;
        }

        // Controleren of gebruiker bestaat voordat deze wordt verwijderd
        $user = $this->userService->getUserByUserId($userId);
        if (!$user)
        {
            // HTTP statuscode 404 (Not Found) meegeven
            $this->jsonErrorResponse('Gebruiker niet gevonden', 404);
            return;
        }

        // Gebruiker verwijderen
        $deleteUser = $this->userService->deleteUser($userId);

        // Als het verwijderen van de gebruiker mislukt is, foutmelding tonen
        if(!$deleteUser)
        {
            // HTTP statuscode 500 (Internal Server Error) meegeven
            $this->jsonErrorResponse('Gebruiker kon niet verwijderd worden', 500);
            return;
        }

        // Succesmelding tonen
        // HTTP statuscode 200 (OK) gebruiken
        $this->jsonSuccessResponse(['message' => 'Gebruiker succesvol verwijderd!']);
    }

    // Helpermethodes //
    private function userIsAdministrator(): bool
    {
        // Controleren of gebruiker ingelogd is
        if (!$this->isAuthenticatedUser())
        {
            return false;
        }

        // Controleren of ingelogde gebruiker een administrator is
        if (!$this->validateUserIsAdministrator())
        {
            return false;
        }

        return true;
    } 
}