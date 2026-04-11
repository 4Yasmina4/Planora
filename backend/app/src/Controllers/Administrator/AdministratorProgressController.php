<?php
namespace App\Controllers\Administrator;

use App\Controllers\Administrator\AdministratorBaseController;
use App\Services\IProgressService;
use App\Services\IAuthenticationService;

class AdministratorProgressController extends AdministratorBaseController
{
    private IProgressService $progressService;

    public function __construct(IProgressService $progressService, IAuthenticationService $authenticationService)
    {
        $this->progressService = $progressService;
        // AuthenticationService doorgeven aan de AdministratorBaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }

        // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
        $userId = $this->getIdFromUrlParameters($vars);
        
        // Voortgang ophalen via de IProgressService
        $progress = $this->progressService->getProgressByUserId($userId);

        // Lijst met voortgang terugsturen naar de frontend
        $this->jsonSuccessResponse($progress);
    }

    // Methode die voortgang van alle studenten ophaalt
    public function getAllStudentsProgress(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsAdministrator())
        {
            return;
        }
        
        // Voortgang van alle studenten ophalen via de IProgressService
        $studentsProgress = $this->progressService->getAllStudentsProgress();

        // Lijst met voortgang terugsturen naar de frontend
        $this->jsonSuccessResponse($studentsProgress);
    }
}