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
use App\Controllers\Authentication\AuthenticationController;

// Course imports // 
use App\Repositories\CourseRepository;
use App\Services\CourseService;
use App\Controllers\Student\CourseController;

// Task imports //
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Controllers\Student\TaskController;


// User dependencies //
$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);

// Authentication dependencies //
$authenticationService = new AuthenticationService($userRepository);
$authenticationController = new AuthenticationController($userService, $authenticationService);

// User management dependencies //
$userManagementController = new UserManagementController($userService, $authenticationService);

// Course dependencies //
$courseRepository = new CourseRepository($pdo);
$courseService = new CourseService($courseRepository);
$courseController = new CourseController($courseService, $authenticationService);

// Task dependencies //
$taskRepository = new TaskRepository($pdo);
$taskService = new TaskService($taskRepository);
$taskController = new TaskController($taskService, $authenticationService);