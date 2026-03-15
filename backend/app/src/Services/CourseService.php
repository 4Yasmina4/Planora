<?php
namespace App\Services;

use App\Models\Course;
use App\Repositories\ICourseRepository;
use App\Services\ICourseService;

class CourseService implements ICourseService
{
    private ICourseRepository $iCourseRepository;

    public function __construct(ICourseRepository $iCourseRepository)
    {
        $this->iCourseRepository = $iCourseRepository;
    }

    // Methode om een nieuwe vak aan te maken
    public function createCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course
    {
        // Course-object bouwen met behulp van helpermethode
        $course = $this->buildCourse($userId, $courseName, $courseDescription, $ects, $examDate, $studyMaterial);
        
        // ICourseRepository aanroepen om een nieuwe vak aan te maken
        return $this->iCourseRepository->createCourse($course);
    }

    // Helpermethodes //

    // Methode om een Course-object te bouwen
    private function buildCourse(int $userId, string $courseName, string $courseDescription, int $ects, string $examDate, string $studyMaterial): Course
    {
        // Null teruggeven voor course_id, omdat database deze genereert bij het aanmaken van een nieuw vak
        return new Course(null, $userId, $courseName, $courseDescription, $ects, $examDate, $studyMaterial);
    }
}