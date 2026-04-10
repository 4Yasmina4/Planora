<?php
namespace App\Models;

use JsonSerializable;

class Progress implements JsonSerializable {
    private int $courseId;
    private string $courseName;
    private int $totalTasks;
    private int $completedTasks;
    
    public function __construct(int $courseId, string $courseName, int $totalTasks, int $completedTasks)
    {
        $this->courseId = $courseId;
        $this->courseName = $courseName;
        $this->totalTasks = $totalTasks;
        $this->completedTasks = $completedTasks;
    }

    //Getters
    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getCourseName(): string
    {
        return $this->courseName;
    }

    public function getTotalTasks(): int
    {
        return $this->totalTasks;
    }

    public function getCompletedTasks(): int 
    {
        return $this->completedTasks;
    }

    // Percentage bereken van aantal taken die al af zijn
    public function getCompletedTasksPercentage(): float 
    {
        // Als er geen taken afegerond zijn geef dan 0,0% terug
        if ($this->totalTasks === 0)
        {
            return 0.0;
        }

        // Afgeronde taken percentage berekenen (afronden op 1 decimaal)
        return round(($this->completedTasks / $this->totalTasks) * 100, 1);
    }
    
    // Bepalen welke data omgezet wordt naar JSON formaat en teruggestuurd wordt naar de frontend
    public function jsonSerialize(): array 
    {
        // Een associatieve array is een array waarbij elke waarde een naam (key) heeft in plaats van een getal as index
        return [
            'course_id' => $this->courseId,
            'course_name' => $this->courseName,
            'total_tasks' => $this->totalTasks,
            'completed_tasks' => $this->completedTasks,
            'task_completion_percentage' => $this->getCompletedTasksPercentage()
        ];
    }
}