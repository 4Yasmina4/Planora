<?php
namespace App\Repositories;

use PDO;
use App\Models\Task;
use App\Repositories\ITaskRepository;

class TaskRepository implements ITaskRepository
{
    private PDO $pdo;

    // Constructor die $pdo opslaat
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Methode die alle taken ophaald van een specifieke student op basis van de user_id
    public function getAllTasksByUserId(int $userId): array
    {
        // SQL-query voorbereiden om alle taken op te halen van een specifieke vak
        $stmt = $this->pdo->prepare("SELECT * FROM task WHERE user_id = :user_id ORDER BY date ASC");
        // Placeholder :user_id invullen met waarde van $userId
        $stmt->execute(['user_id' => $userId]);
        
        // Alle rijen ophalen als associatieve arrays (bevat geen nummers maar namen als sleutels)
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Array aanmaken om Task-objecten in op te slaan
        $tasks = [];

        // Elk database-rij wordt omgezet naar Task-object en vervolgens toegevoegd aan de lijst
        foreach ($rows as $row)
        {
            $tasks[] = $this->mapRowToTaskObject($row);
        }

        // Lijst met Task-objecten teruggeven
        return $tasks;
    }

    // Methode die één specifieke taak ophaald op basis van de task_id
    public function getTaskByTaskId(int $taskId): ?Task
    {
        //SQL-query die 1 taak ophaalt op basis van task_id
        $stmt = $this->pdo->prepare("SELECT * FROM task WHERE task_id = :task_id");
        
        //Voert bovenstaande SQL-query uit en vult ':task_id' met waarde van $taskId
        $stmt->execute(['task_id' => $taskId]);

        //Haalt 1 rij uit database op als een associatieve array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Als er geen taak is gevonden, geeft de functie null terug
        if (!$row)
        {
            return null;
        }

        //Zet de opgehaalde databse-rij om naar een Task-Object
        return $this->mapRowToTaskObject($row);
    }
 
    // Methode om een nieuwe taak aan te maken
    public function createTask(Task $task): Task
    {
        // SQL INSERT-query voorbereiden om een nieuwe taak aan te maken
        $stmt = $this->pdo->prepare("
                INSERT INTO task (user_id, course_id, task_name, task_description, date, task_duration, is_completed)
                VALUES (:user_id, :course_id, :task_name, :task_description, :date, :task_duration, :is_completed)
        ");

        // INSERT-query uitvoeren met de waarden uit het Task-object
        $stmt->execute([
            'user_id' => $task->getUserId(),
            'course_id' => $task->getCourseId(),
            'task_name' => $task->getTaskName(),
            'task_description' => $task->getTaskDescription(),
            'date' => $task->getDate(),
            'task_duration' => $task->getTaskDuration(),
            'is_completed' => $task->isCompleted() ? 1 : 0
        ]);

        // Database genereert een nieuwe task_id; deze wordt gebruikt om een volledige Task-object terug te geven
        $taskId = (int)$this->pdo->lastInsertId();

        // Task-object aanmaken met nieuwe gegenereerde task_id via helpermethode
        return $this->mapTaskWithTaskId($task, $taskId);
    }

    // Methode om taakgegevens te wijzigen
    public function updateTask(int $taskId, string $taskName, string $taskDescription, string $date, int $taskDuration, bool $isCompleted): Task
    {
        // SQL UPDATE-query voorbereiden om vakgegevens te wijzigen op basis van de course_id
        $stmt = $this->pdo->prepare("UPDATE task
                                     SET task_name = :task_name, task_description = :task_description, date = :date, task_duration = :task_duration, is_completed = :is_completed
                                     WHERE task_id = :task_id");
            
        // UPDATE-query uitvoeren met de nieuwe waarden
        $stmt->execute(['task_name' => $taskName, 'task_description' => $taskDescription, 'date' => $date, 'task_duration' => $taskDuration, 'is_completed' => $isCompleted ? 1 : 0, 'task_id' => $taskId]);

        // Gewijzigde taak opnieuw ophalen uit de database en teruggeven
        return $this->getTaskByTaskId($taskId);
    }

    // Methode om een taak te verwijderen van een speciefieke student op basis van de task_id
    public function deleteTask(int $taskId): bool
    {
        // SQL DELETE-query voorbereiden om een taal te verwijderen op basis van de task_id
        // :task_id is een placeholder en voorkomt SQL-injectie
        $stmt = $this->pdo->prepare("DELETE FROM task WHERE task_id = :task_id");

        // SQL DELETE-query uitvoeren met de waarde van $taskId
        // Execute geeft 'true' terug als een taak succesvol verwijderd is en 'false' als dit niet het geval is
        return $stmt->execute(['task_id' => $taskId]);
    }

    // Helpermethodes //
    // private //
    // Methode dat een nieuwe Task-object
    private function mapTaskWithTaskId(Task $task, int $taskId): Task
    {
        return new Task(
            $taskId,
            $task->getUserId(),
            $task->getCourseId(),
            $task->getTaskName(),
            $task->getTaskDescription(),
            $task->getDate(),
            $task->getTaskDuration(),
            $task->isCompleted()
        );
    }

    // public //
    // Methode dat Task-objecten aanmaakt van de opgehaalde database gegevens
    public function mapRowToTaskObject(array $row): Task
    {
        return new Task(
            (int)$row['task_id'],
            (int)$row['user_id'],
            (int)$row['course_id'],
            $row['task_name'],
            $row['task_description'],
            $row['date'],
            $row['task_duration'],
            (bool)$row['is_completed'],
            $row['created_at'],
            $row['updated_at'],
        );
    }
}