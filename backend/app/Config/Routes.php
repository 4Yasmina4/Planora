<?php
// Dit bestand definieert alle routes van de applicatie
// Het vertelt aan FastRoute dat als er een verzoek binnenkomt op dit pad met deze HTTP methode, dat er een specifieke controller methode moet worden aangeroepen
// Elke route koppelt een HTTP methode en URL pad aan een methode van een controller
// Bijvoorbeeld: POST /users → UserManagementController::createUser

use FastRoute\RouteCollector;

// Anonieme functie teruggeven die de routes definieert
// RouteCollector $router beheert de routes
// use ($userManagementController) maakt de UserManagementController beschikbaar binnen de functie
return function (RouteCollector $router) use ($userManagementController, $authenticationController, $courseController, $taskController, $progressController, $administratorProgressController)
{
    // Administrator - User //
    // POST /users → roept de createUser methode aan van de UserManagementController
    // Deze wordt aangeroepen wanneer de administrator een nieuwe gebruiker aanmaakt
    $router->addRoute('POST', '/users', [$userManagementController, 'createUser']);
    // GET /users/{id:\d+} → haalt één gebruiker op op basis van user_id
    $router->addRoute('GET', '/users/{id:\d+}', [$userManagementController, 'getUserByUserId']);
    // GET /users → roept de getAllUsers methode aan van de UserManagementController
    $router->addRoute('GET', '/users', [$userManagementController, 'getAllUsers']);
    // PUT /users/{id:\d+} → gebruikersgegevens van een gebruiker wijzigen
    $router->addRoute('PUT', '/users/{id:\d+}', [$userManagementController, 'updateUser']);
    // DELETE /users/{id:\d+} → roept de deleteUser methode aan van de UserManagementController
    $router->addRoute('DELETE', '/users/{id:\d+}', [$userManagementController, 'deleteUser']);


    // Authentication - User //
    // POST /login → roept de login methode aan in de AuthenticationController
    $router->addRoute('POST', '/login', [$authenticationController, 'login']);
    // POST /register → roept de register methode aan in de AuthenticationController
    $router->addRoute('POST', '/register', [$authenticationController, 'register']);


    // Courses - Student //
    // POST /courses → roept de createCourse methode aan in de CourseController
    $router->addRoute('POST', '/courses', [$courseController, 'createCourse']);
    // GET /courses → roept de getAllCoursesByUserId methode aan in de CourseController
    $router->addRoute('GET', '/courses', [$courseController, 'getAllCoursesByUserId']);
    // GET /courses/{id:\d+} → roept de getCourseByCourseId methode aan in de CourseController
    $router->addRoute('GET', '/courses/{id:\d+}', [$courseController, 'getCourseByCourseId']);
    // PUT /courses/{id:\d+} → vakgegevens van een vak wijzigen
    $router->addRoute('PUT', '/courses/{id:\d+}', [$courseController, 'updateCourse']);
    // DELETE /courses/{id:\d+} → roept de deleteCourse methode aan van de CourseController
    $router->addRoute('DELETE', '/courses/{id:\d+}', [$courseController, 'deleteCourse']);

    // Tasks - Student //
    // POST /tasks → roept de createTask methode aan in de TaskController
    $router->addRoute('POST', '/tasks', [$taskController, 'createTask']);
    // GET /tasks → roept de getAllTasksByUserId methode aan in de TaskController
    $router->addRoute('GET', '/tasks', [$taskController, 'getAllTasksByUserId']);
    // GET /tasks/{id:\d+} → roept de getTaskByTaskId methode aan in de TaskController
    $router->addRoute('GET', '/tasks/{id:\d+}', [$taskController, 'getTaskByTaskId']);
    // PUT /tasks/{id:\d+} → taakgegevens wijzigen
    $router->addRoute('PUT', '/tasks/{id:\d+}', [$taskController, 'updateTask']);
    // DELETE /tasks/{id:\d+} → roept de deleteTask methode aan van de TaskController
    $router->addRoute('DELETE', '/tasks/{id:\d+}', [$taskController, 'deleteTask']);

    // Progress - Student //
    // GET /progress → roept de getProgressByUserId methode aan in de ProgressController
    $router->addRoute('GET', '/progress', [$progressController, 'getProgressByUserId']);

    // Progress - Administrator //
    // GET /administrator/students/{id:\d+}/progress → roept de getProgressByUserId methode aan in de AdministratorProgressController
    $router->addRoute('GET', '/administrator/students/{id:\d+}/progress', [$administratorProgressController, 'getProgressByUserId']);
};