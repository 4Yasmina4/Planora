<?php
namespace App\Services;

use App\Models\Course;

interface ICourseService
{

    // Methode om een nieuwe vak aan te maken
    public function createCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course;
}