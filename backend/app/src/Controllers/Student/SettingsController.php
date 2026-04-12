<?php
namespace App\Controllers\Student;

use App\Controllers\Student\StudentBaseController;
use App\Services\IUserService;
use App\Services\IAuthenticationService;

class SettingsController extends StudentBaseController
{
    private IUserService $userService;

    public function __construct(IUserService $userService, IAuthenticationService $authenticationService)
    {
        $this->userService = $userService;
        // AuthenticationService doorgeven aan de StudentBaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode om eigen account als student te verwijderen
    public function deleteOwnStudentAccount(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();
        
        // Controleren of gebruiker (student) bestaat voordat deze wordt verwijderd
        $studentUser = $this->userService->getUserByUserId($userId);
        if (!$studentUser)
        {
            // HTTP statuscode 404 (Not Found) meegeven
            $this->jsonErrorResponse('Gebruiker niet gevonden.', 404);
            return;
        }

        // Eigen account verwijderen
        $deleteUser = $this->userService->deleteUser($userId);

        // Als het verwijderen mislukt is, foutmelding tonen
        if (!$deleteUser)
        {
            // HTTP statuscode 500 (Internal Server Error) meegeven
            $this->jsonErrorResponse('Account kon niet verwijderd worden.', 500);
            return;
        }

        // Succesmelding tonen
        $this->jsonSuccessResponse(['message' => 'Account succesvol verwijderd!']);
    }
}