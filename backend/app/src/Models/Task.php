<?php
namespace App\Models;

use JsonSerializable;

class Task implements JsonSerializable {
    private ?int $taskId;
    private int $userId; // Foreign key naar de primary key user_id in tabel user
    private int $courseId; // Foreign key naar de primary key course_id in tabel course
    private string $taskName;
    private string $taskDescription;
    private string $date;
    private int $taskDuration;
    private bool $isCompleted;
    // null toestaan omdat deze automatisch door de database wordt gegenereerd
    private ?string $createdAt; 
    private ?string $updatedAt;

    // createdAt en updatedAt krijgen standaat null waarde, omdat deze automatisch door de database worden gegenereerd
    public function __construct(?int $taskId, int $userId, int $courseId, string $taskName, string $taskDescription, string $date, int $taskDuration,
                                bool $isCompleted, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->taskId = $taskId;
        $this->userId = $userId;
        $this->courseId = $courseId;
        $this->taskName = $taskName;
        $this->taskDescription = $taskDescription;
        $this->date = $date;
        $this->taskDuration = $taskDuration;
        $this->isCompleted = $isCompleted;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    //Getters
    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getTaskName(): string 
    {
        return $this->taskName;
    }

    public function getTaskDescription(): string 
    {
        return $this->taskDescription;
    }
    
    public function getDate(): string 
    {
        return $this->date;
    }
    
    public function getTaskDuration(): int 
    {
        return $this->taskDuration;
    }
    
    public function isCompleted(): bool 
    {
        return $this->isCompleted;
    }

    public function getCreatedAt(): ?string 
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string 
    {
        return $this->updatedAt;
    }
    
    // Bepalen welke data omgezet wordt naar JSON formaat en teruggestuurd wordt naar de frontend
    public function jsonSerialize(): array 
    {
        // Een associatieve array is een array waarbij elke waarde een naam (key) heeft in plaats van een getal as index
        return [
            'task_id' => $this->taskId,
            'user_id' => $this->userId,
            'course_id' => $this->courseId,
            'task_name' => $this->taskName,
            'task_description' => $this->taskDescription,
            'date' => $this->date,
            'task_duration' => $this->taskDuration,
            'is_completed' => $this->isCompleted,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}