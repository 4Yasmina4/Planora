<?php
namespace App\Repositories;

use App\Models\Course;

interface ICourseRepository
{
    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(int $userId): array;
    // Methode die één specifieke vak ophaald op basis vaan de couse_id
    public function getCourseByCourseId(int $courseId): ?Course;
    // Methode om een nieuwe vak aan te maken
    public function createCourse(Course $course): Course;
    // Methode om een vak te verwijderen van een speciefieke student op basis van de course_id
    public function deleteCourse(int $courseId): bool;
}