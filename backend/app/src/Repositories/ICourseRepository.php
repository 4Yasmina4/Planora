<?php
namespace App\Repositories;

use App\Models\Course;

interface ICourseRepository
{
    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(int $userId): array;
    // Methode om een nieuwe vak aan te maken
    public function createCourse(Course $course): Course;
}