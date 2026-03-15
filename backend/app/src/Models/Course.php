<?php
namespace App\Models;

use JsonSerializable;

class Course implements JsonSerializable {
    //Private attributen voor veiligheidsredenen
    private ?int $courseId; // null alleen toegestaan bij het aanmaken van een nieuwe course, omdat deze nog door de database gegenereerd moet worden
    private int $userId; // Foreign key naar de primary key user_id in tabel user
    private string $courseName;
    private string $courseDescription;
    private int $ects;
    private string $examDate;
    private string $studyMaterial;
    private ?string $createdAt; // null toestaan omdat deze automatisch door de database wordt gegenereerd
    private ?string $updatedAt; // null toestaan omdat deze automatisch door de database wordt gegenereerd

    // createdAt en updatedAt krijgen standaat null waarde, omdat deze automatisch door de database worden gegenereerd
    // bij het aanmaken van een nieuwe course
    public function __construct(?int $courseId, int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial,
                                ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
        $this->courseDescription = $courseDescription;
        $this->ects = $ects;
        $this->examDate = $examDate;
        $this->studyMaterial = $studyMaterial;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    //Getters
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getCourseName(): string 
    {
        return $this->courseName;
    }

    public function getCourseDescription(): string 
    {
        return $this->courseDescription;
    }
    
    public function getEcts(): int 
    {
        return $this->ects;
    }

    public function getExamDate(): string 
    {
        return $this->examDate;
    }
    
    public function getStudyMaterial(): string 
    {
        return $this->studyMaterial;
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
        // Een associatieve array terugsturen met de gegevens van de course.
        // Een associatieve array is een array waarbij elke waarde een naam (key) heeft in plaats van een getal as index
        return [
            'course_id' => $this->courseId,
            'user_id' => $this->userId,
            'course_name' => $this->courseName,
            'course_description' => $this->courseDescription,
            'ects' => $this->ects,
            'exam_date' => $this->examDate,
            'study_material' => $this->studyMaterial,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}