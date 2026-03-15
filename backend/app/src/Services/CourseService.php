<?php
namespace App\Services;

use App\Models\Course;
use App\Repositories\ICourseRepository;
use App\Services\ICourseService;

class CourseService implements ICourseService
{
    private ICourseRepository $courseRepository;

    public function __construct(ICourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(int $userId): array
    {
        return $this->courseRepository->getAllCoursesByUserId($userId);
    }

    // Methode die één specifieke vak ophaald op basis vaan de couse_id
    public function getCourseByCourseId(int $courseId): ?Course
    {
        return $this->courseRepository->getCourseByCourseId($courseId);
    }

    // Methode om een nieuwe vak aan te maken
    public function createCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course
    {
        // Course-object bouwen met behulp van helpermethode
        $course = $this->buildCourse($userId, $courseName, $courseDescription, $ects, $examDate, $studyMaterial);
        
        // ICourseRepository aanroepen om een nieuwe vak aan te maken
        return $this->courseRepository->createCourse($course);
    }

    // Methode om vakgegevens te wijzigen op basis van de course_id
    public function updateCourse(int $courseId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course
    {
        return $this->courseRepository->updateCourse($courseId, $courseName, $courseDescription, $ects, $examDate, $studyMaterial);
    }

    // Methode om een vak te verwijderen op basis van de course_id
    // Deze methode geeft een bool terug, omdat na het verwijderen van een vak het handig is om te weten of dit is gelukt
    // Hierbij is het onnodig om een Course-object terug te geven
    public function deleteCourse(int $courseId): bool
    {
        //ICourseRepository aanroepen om een vak te verwijderen
        return $this->courseRepository->deleteCourse($courseId);
    }

    // Helpermethodes //

    // Methode om een Course-object te bouwen
    private function buildCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course
    {
        // Null teruggeven voor course_id, omdat database deze genereert bij het aanmaken van een nieuw vak
        return new Course(null, $userId, $courseName, $courseDescription, $ects, $examDate, $studyMaterial);
    }
}