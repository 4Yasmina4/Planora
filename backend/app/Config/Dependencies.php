<?php
// Dit bestand bouwt de dependencies op voor de applicatie
// De dependencies worden van onder naar boven gebouwd: 
// 1. Repository (database), 2. Service (logica), 3. Controller (HTTP verzoeken) 

// User dependencies
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Controllers\Administrator\UserManagementController;

$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);
$userManagementController = new UserManagementController($userService);