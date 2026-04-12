<?php
namespace App\Controllers\Student;

use App\Controllers\Student\StudentBaseController;
use App\Services\IProgressService;
use App\Services\IAuthenticationService;

class ProgressController extends StudentBaseController
{
    private IProgressService $progressService;

    public function __construct(IProgressService $progressService, IAuthenticationService $authenticationService)
    {
        $this->progressService = $progressService;
        // AuthenticationService doorgeven aan de StudentBaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();
        
        // Voortgang ophalen via de IProgressService
        $progress = $this->progressService->getProgressByUserId($userId);

        // Lijst met voortgang terugsturen naar de frontend
        $this->jsonSuccessResponse($progress);
    }
}