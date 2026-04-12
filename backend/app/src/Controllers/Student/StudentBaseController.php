<?php
namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Services\IAuthenticationService;

class StudentBaseController extends BaseController
{
    public function __construct(IAuthenticationService $authenticationService)
    {
        // IAuthenticationService doorgeven aan de BaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Controleren of de ingelogde gebruiker een student is
    protected function userIsStudent(): bool
    {
        // Controleren of gebruiker ingelogd is
        if (!$this->isAuthenticatedUser())
        {
            return false;
        }

        // Controleren of ingelogde gebruiker een student is
        if (!$this->validateUserIsStudent())
        {
            return false;
        }

        return true;
    } 
}