<?php
namespace App\Controllers\Administrator;

use App\Controllers\BaseController; //controleren of basecontroller in controllers map moet of framework
use App\Services\UserService;

class UserManagementController extends BaseController
{
    private UserService $userService;

    // UserService via dependency injection meegeven.
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Alle gebruikers ophalen
    public function getAllUsers(): void 
    {
        // Alle gebruikers ophalen via de UserService
        $users = $this->userService->getAllUsers();

        // Lijst met gebruikers terugsturen naar de frontend
        $this->jsonSuccessResponse($users);
    }

    // Één gebruiker ophalen
    public function getUserByUserId(array $vars): void
    {
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

    // Nieuwe gebruiker aanmaken
    public function createUser(): void
    {
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

        // Nieuwe gebruiker aanmaken via de UserService methode createUser
        // Password meegeven en geen hashedPassword, omdat de Userservice het wachtwoord hasht
        $newUser = $this->userService->createUser($userData['first_name'], $userData['surname_prefix'] ?? null, $userData['last_name'], $userData['email'], $userData['password'], $userData['role']);

        // Succesmelding tonen
        // HTTP statuscode 201 (Created) gebruiken; nieuw object succesvol aangemaakt
        $this->jsonSuccessResponse($newUser, 201);
    }

    // Gebruiker verwijderen op basis van de user_id
    public function deleteUser(array $vars): void 
    {
        // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
        // Dit via de helpermethode in de BaseController doen
        // $vars is een array die door FastRoute wordt aangemaakt op basis van de URL
        // Bijvoorbeeld: /users/5 → $vars = ['id' => 5] → geeft 5 terug als integer
        $userId = $this->getIdFromUrlParameters($vars);

        // Controleren of gebruiker bestaat voordat deze wordt verwijderd
        $user = $this->userService->getUserByUserId($userId);
        if (!$user)
        {
            // HTTP statuscode 404 (Not Found) meegeven
            $this->jsonErrorResponse('Gebruiker niet gevonden', 404);
            return;
        }

        // Gebruiker verwijderen via de UserService
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
}