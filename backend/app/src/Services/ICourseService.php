<?php
namespace App\Services;

use App\Models\Course;

interface ICourseService
{
    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(int $userId): array;
    // Methode die één specifieke vak ophaald op basis vaan de course_id
    public function getCourseByCourseId(int $courseId): ?Course;
    // Methode om een nieuwe vak aan te maken
    public function createCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course;
    // Methode om vakgegevens te wijzigen op basis van de course_id
    public function updateCourse(int $courseId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course;
    // Methode om een vak te verwijderen van een speciefieke student op basis van de course_id
    public function deleteCourse(int $courseId): bool;
}