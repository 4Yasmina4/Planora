<?php
// Dit bestand definieert alle routes van de applicatie
// Het vertelt aan FastRoute dat als er een verzoek binnenkomt op dit pad met deze HTTP methode, dat er een specifieke controller methode moet worden aangeroepen
// Elke route koppelt een HTTP methode en URL pad aan een methode van een controller
// Bijvoorbeeld: POST /users → UserManagementController::createUser

use FastRoute\RouteCollector;

// Anonieme functie teruggeven die de routes definieert
// RouteCollector $router beheert de routes
// use ($userManagementController) maakt de UserManagementController beschikbaar binnen de functie
return function (RouteCollector $router) use ($userManagementController)
{
    // Administrator - User //
    // POST /users → roept de createUser methode aan van de UserManagementController
    // Deze wordt aangeroepen wanneer de administrator een nieuwe gebruiker aanmaakt
    $router->addRoute('POST', '/users', [$userManagementController, 'createUser']);

    // GET /users → roept de getAllUsers methode aan van de UserManagementController
    $router->addRoute('GET', '/users', [$userManagementController, 'getAllUsers']);
};