<?php
namespace App\Services;

use App\Models\Task;

interface ITaskService
{
    // Methode die alle taken ophaald van een specifieke student op basis van de user_id
    public function getAllTasksByUserId(int $userId): array;
    // Methode die één specifieke taak ophaald op basis vaan de task_id
    public function getTaskByTaskId(int $taskId): ?Task;
    // Methode om een nieuwe taak aan te maken
    public function createTask(int $userId, int $courseId, string $taskName, string $taskDescription, string $date, int $taskDuration, bool $isCompleted): Task;
    // Methode om taakgegevens te wijzigen
    public function updateTask(int $taskId, string $taskName, string $taskDescription, string $date, int $taskDuration, bool $isCompleted): Task;
    // Methode om een taak te verwijderen van een speciefieke student op basis van de task_id
    public function deleteTask(int $taskId): bool;
}