<?php
namespace App\Services;

use App\Models\Task;
use App\Repositories\ITaskRepository;
use App\Services\ITaskService;

class TaskService implements ITaskService
{
    private ITaskRepository $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    
    // Methode die alle taken ophaald van een specifieke student op basis van de user_id
    public function getAllTasksByUserId(int $userId): array
    {
        return $this->taskRepository->getAllTasksByUserId($userId);
    }

    // Methode die één specifieke taak ophaald op basis van de task_id
    public function getTaskByTaskId(int $taskId): ?Task
    {
        return $this->taskRepository->getTaskByTaskId($taskId);
    }

    // Methode om een nieuwe taak aan te maken
    public function createTask(int $userId, int $courseId, string $taskName, string $taskDescription, string $date, int $taskDuration, bool $isCompleted): Task
    {
        // Task-object bouwen met behulp van helpermethode
        $task = $this->buildTask($userId, $courseId, $taskName, $taskDescription, $date, $taskDuration, $isCompleted);
        
        // ITaskRepository aanroepen om een nieuwe taak aan te maken
        return $this->taskRepository->createTask($task);
    }

    // Methode om taakgegevens te wijzigen
    public function updateTask(int $taskId, string $taskName, string $taskDescription, string $date, int $taskDuration, bool $isCompleted): Task
    {
        return $this->taskRepository->updateTask($taskId, $taskName, $taskDescription, $date, $taskDuration, $isCompleted);
    }

    // Methode om een taak te verwijderen van een speciefieke student op basis van de task_id
    public function deleteTask(int $taskId): bool
    {
        //ITaskRepository aanroepen om een taak te verwijderen
        return $this->taskRepository->deleteTask($taskId);
    }

    // Helpermethodes //
    // Methode om een Task-object te bouwen
    private function buildTask(int $userId, int $courseId, string $taskName, string $taskDescription, string $date, int $taskDuration, bool $isCompleted): Task
    {
        // Null teruggeven voor task_id, omdat database deze genereert bij het aanmaken van een nieuw taak
        return new Task(null, $userId, $courseId, $taskName, $taskDescription, $date, $taskDuration, $isCompleted);
    }
}