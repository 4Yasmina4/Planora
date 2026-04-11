<?php
namespace App\Controllers\Administrator;

use App\Controllers\BaseController;
use App\Services\IAuthenticationService;

class AdministratorBaseController extends BaseController
{
    public function __construct(IAuthenticationService $authenticationService)
    {
        // IAuthenticationService doorgeven aan de BaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Controleren of de ingelogde gebruiker een administrator is
    protected function userIsAdministrator(): bool
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