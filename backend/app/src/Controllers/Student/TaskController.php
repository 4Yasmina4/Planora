<?php
namespace App\Controllers\Student;

use App\Controllers\Student\StudentBaseController;
use App\Models\Task;
use App\Services\ITaskService;
use App\Services\IAuthenticationService;

class TaskController extends StudentBaseController
{
    private ITaskService $taskService;

    public function __construct(ITaskService $taskService, IAuthenticationService $authenticationService)
    {
        $this->taskService = $taskService;
        // AuthenticationService doorgeven aan de StudentBaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode die alle taken ophaald van een specifieke student op basis van de user_id
    public function getAllTasksByUserId(): void
    {
       // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();
        
        // Alle taken ophalen via de ITaskService
        $tasks = $this->taskService->getAllTasksByUserId($userId);

        // Lijst met taken terugsturen naar de frontend
        $this->jsonSuccessResponse($tasks);
    }

    // Methode die één specifieke taak ophaald op basis van de task_id
    public function getTaskByTaskId(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // task_id ophalen uit de URL parameters
        $taskId = $this->getIdFromUrlParameters($vars);

        // Controleren of taak bestaat en van de ingelogde student is
        $task = $this->validateTaskOwnership($taskId, $userId);
        if (!$task)
        {
            return;
        }

        // Taak van ingelogde student terugsturen naar de frontend
        $this->jsonSuccessResponse($task);
    }

    // Methode om een nieuwe taak aan te maken
    public function createTask(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // Taskdata ophalen uit de request body
        $taskData = $this->getJsonDataFromRequestBody();
        
        // Controleren of alle verplichten velden ingevuld zijn bij het aanmaken van een nieuw taak
        $requiredTaskData = $this->validateRequiredFormFields($taskData, ['course_id', 'task_name', 'task_description', 'date', 'task_duration']);
        if (!$requiredTaskData)
        {
            // Als niet alle verplichte velden zijn ingevuld, foutmelding geven
            $this->jsonErrorResponse('Taknaam, beschrijving, datum en tijdsduur zijn verplicht.');
            return;
        }

        // isCompleted uit de requesy body, standaard false als niet aanwezig
        $isCompleted = isset($taskData['is_completed']) ? (bool)$taskData['is_completed'] : false; 

        // Nieuwe taak aanmaken
        $newTask = $this->taskService->createTask($userId, $taskData['course_id'], $taskData['task_name'], $taskData['task_description'], $taskData['date'], $taskData['task_duration'], $isCompleted);

        // Succesmelding tonen
        // HTTP statuscode 201 (Created) gebruiken; nieuw object succesvol aangemaakt
        $this->jsonSuccessResponse($newTask, 201);
    }

    // Methode om taakgegevens te wijzigen
    public function updateTask(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // task_id ophalen uit de URL parameters via een helpermethode in de BaseController
        $taskId = $this->getIdFromUrlParameters($vars);
        
        // Controleren of taak bestaat en van de ingelogde student is
        $task = $this->validateTaskOwnership($taskId, $userId);
        if (!$task)
        {
            return;
        }

        // Taskdata ophalen uit de request body
        $taskData = $this->getJsonDataFromRequestBody();

        // Taskdata valideren
        $requiredTaskData = $this->validateRequiredFormFields($taskData, ['task_name', 'task_description', 'date', 'task_duration']);
        if (!$requiredTaskData)
        {
            $this->jsonErrorResponse('Taaknaam, beschrijving, datum, tijdsduur zijn verplicht.');
            return;
        }

        // isCompleted uit de requesy body, standaard false als niet aanwezig
        $isCompleted = isset($taskData['is_completed']) ? (bool)$taskData['is_completed'] : false; 

        // Taakgegevens wijzigen
        $updatedTask = $this->taskService->updateTask($taskId, $taskData['task_name'], $taskData['task_description'], $taskData['date'], $taskData['task_duration'], $isCompleted);

        // Gewijzigde taak terugsturen naar de frontend
        $this->jsonSuccessResponse($updatedTask);
    }

    // Methode om een taak te verwijderen van een speciefieke student
    public function deleteTask(array $vars): void 
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // task_id ophalen uit de URL parameters
        $taskId = $this->getIdFromUrlParameters($vars);
        
        // Controleren of de taak bestaat en van de ingelogde student is
        $task = $this->validateTaskOwnership($taskId, $userId);
        if (!$task)
        {
            return;
        }

        // Taak verwijderen
        $deletedTask = $this->taskService->deleteTask($taskId);
        if (!$deletedTask)
        {
            // Als taal niet verwijderd kon worden HTTP statuscode 500 (Internal Server Error) meegeven
            $this->jsonErrorResponse('Taak kon niet verwijderd worden', 500);
        }

        // Succesmelding tonen
        // HTTP statuscode 200 (OK) gebruiken
        $this->jsonSuccessResponse(['message' => 'Taak is succesvol verwijderd!']);
    }

    // Helpermethodes //
    // Helpermethode om een taak op te halen en te controleren of het van de ingelogde student is
    private function validateTaskOwnership(int $taskId, int $userId): ?Task 
    {
        // Controleren of de taak bestaat
        $task = $this->taskService->getTaskByTaskId($taskId);
        if (!$task)
        {
            // HTTP statuscode 404 (Not Found) meegeven
            $this->jsonErrorResponse('Taak niet gevonden', 404);
            return null;
        }

        // Controleren of de taak van de ingelogde student is
        if ($task->getUserId() !== $userId)
        {
            // HTTP statuscode 403 (Forbidden) meegeven
            $this->jsonErrorResponse('Geen toegang tot deze taak', 403);
            return null;
        }

        // Taak teruggeven als het van de ingelogde student is
        return $task;
    }
}