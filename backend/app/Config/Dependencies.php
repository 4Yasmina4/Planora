<?php
// Dit bestand bouwt de dependencies op voor de applicatie
// De dependencies worden van onder naar boven gebouwd: 
// 1. Repository (database), 2. Service (logica), 3. Controller (HTTP verzoeken) 

// User imports //
use App\Repositories\IUserRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Controllers\Administrator\UserManagementController;

// Authentication imports //
use App\Services\IAuthenticationService;
use App\Services\AuthenticationService;
use App\Controllers\Authentication\LoginController;
use App\Controllers\Authentication\RegisterController;

// Course imports // 
use App\Repositories\CourseRepository;
use App\Services\CourseService;
use App\Controllers\Student\CourseController;


// User dependencies //
$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);

// Authentication dependencies //
$authenticationService = new AuthenticationService($userRepository);
$loginController = new LoginController($userService, $authenticationService);
$registerController = new RegisterController($userService, $authenticationService);

// User management dependencies //
$userManagementController = new UserManagementController($userService, $authenticationService);

// Course dependencies //
$courseRepository = new CourseRepository($pdo);
$courseService = new CourseService($courseRepository);
$courseController = new CourseController($courseService, $authenticationService);