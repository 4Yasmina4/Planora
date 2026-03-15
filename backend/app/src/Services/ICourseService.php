<?php
namespace App\Services;

use App\Models\Course;

interface ICourseService
{
    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(int $userId): array;
    // Methode om een nieuwe vak aan te maken
    public function createCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course;
}