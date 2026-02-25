<?php
namespace App\Controllers\Administrator;

use App\Controllers\BaseController; //controleren of basecontroller in controllers map moet of framework
use App\Services\UserService;

class UserManagementController extends BaseController
{
    private UserService $userService;

    //UserService via dependency injection meegeven.
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //Nieuwe gebruiker aanmaken
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
}