<?php
namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Services\IProgressService;
use App\Services\IAuthenticationService;

class ProgressController extends BaseController
{
    private IProgressService $progressService;

    public function __construct(IProgressService $progressService, IAuthenticationService $authenticationService)
    {
        $this->progressService = $progressService;
        // AuthenticationService doorgeven aan de BaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(): void
    {
        // user_id ophalen en controleren of de gebruiker ingelogd is via een helpermethode in de BaseController
        $userId = $this->validateUserAuthentication();

        // Als er geen geldig user_id is, is de gebruiker niet ingelogd
        if (!$userId)
        {
            // Foutmelding wordt al verstuurd in de methode validateUserAuthentication in de BaseController
            // Functie stoppen
            return;
        }
        
        // Voortgang ophalen via de IProgressService
        $progress = $this->progressService->getProgressByUserId($userId);

        // Lijst met voortgang terugsturen naar de frontend
        $this->jsonSuccessResponse($progress);
    }
}