<?php
namespace App\Controllers\Student;

use App\Controllers\Student\StudentBaseController;
use App\Models\Course;
use App\Services\ICourseService;
use App\Services\IAuthenticationService;

class CourseController extends StudentBaseController
{
    private ICourseService $courseService;

    // ICourseService via dependency injection meegeven
    public function __construct(ICourseService $courseService, IAuthenticationService $authenticationService)
    {
        $this->courseService = $courseService;
        // AuthenticationService doorgeven aan de StudentBaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();
        
        // Alle vakken ophalen via de ICourseService
        $courses = $this->courseService->getAllCoursesByUserId($userId);

        // Lijst met vakken terugsturen naar de frontend
        $this->jsonSuccessResponse($courses);
    }

    // Methode die één specifieke vak ophaald op basis vaan de course_id
    public function getCourseByCourseId(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // course_id ophalen uit de URL parameters
        $courseId = $this->getIdFromUrlParameters($vars);

        // Controleren of het vak bestaat en van de ingelogde student is
        $course = $this->validateCourseOwnership($courseId, $userId);
        if (!$course)
        {
            return;
        }

        // Vak van ingelogde student terugsturen naar de frontend
        $this->jsonSuccessResponse($course);
    }

    // Methode om een nieuwe vak aan te maken
    public function createCourse(): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // Coursedata ophalen uit de request body via methode getJsonDataFromRequestBody in BaseController
        $courseData = $this->getJsonDataFromRequestBody();
        
        // Coursedata valideren; controleren of alle verplichten velden ingevuld zijn bij het aanmaken van een nieuw vak
        // Hierbij alleen attributen valideren die ingevuld moeten zijn
        $requiredCourseData = $this->validateRequiredFormFields($courseData, ['course_name', 'course_description', 'ects', 'exam_date', 'study_material']);
        if (!$requiredCourseData)
        {
            // Als niet alle verplichte velden zijn ingevuld, foutmelding geven
            // Foutmelding met behulp van helpermethode in BaseController tonen
            $this->jsonErrorResponse('Vaknaam, beschrijving, ECTS, en studiemateriaal zijn verplicht.');
            return;
        }

        // Nieuwe vak aanmaken via de CourseService
        $newCourse = $this->courseService->createCourse($userId, $courseData['course_name'], $courseData['course_description'], $courseData['ects'], $courseData['exam_date'], $courseData['study_material']);

        // Succesmelding tonen
        // HTTP statuscode 201 (Created) gebruiken; nieuw object succesvol aangemaakt
        $this->jsonSuccessResponse($newCourse, 201);
    }

    // Methode om vakgegevens te wijzigen op basis van de course_id
    public function updateCourse(array $vars): void
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // course_id ophalen uit de URL parameters via een helpermethode in de BaseController
        $courseId = $this->getIdFromUrlParameters($vars);
        
        // Controleren of het vak bestaat en van de ingelogde student is
        $course = $this->validateCourseOwnership($courseId, $userId);
        if (!$course)
        {
            return;
        }

        // Coursedata ophalen uit de request body via methode getJsonDataFromRequestBody in de BaseController
        $courseData = $this->getJsonDataFromRequestBody();

        // Coursedata valideren
        $requiredCourseData = $this->validateRequiredFormFields($courseData, ['course_name', 'course_description', 'ects', 'exam_date', 'study_material']);
        if (!$requiredCourseData)
        {
            $this->jsonErrorResponse('Vaknaam, beschrijving, ECTS, tentamendatum en studiemateriaal zijn verplicht.');
            return;
        }

        // Vakgegevens wijzigen via ICourseService
        $updatedCourse = $this->courseService->updateCourse($courseId, $courseData['course_name'], $courseData['course_description'], $courseData['ects'], $courseData['exam_date'], $courseData['study_material']);

        // Gewijzigde vak terugsturen naar de frontend
        $this->jsonSuccessResponse($updatedCourse);
    }

    // Methode om vak te verwijderen op basis van de course_id
    public function deleteCourse(array $vars): void 
    {
        // Gebruiker authorizeren
        if (!$this->userIsStudent())
        {
            return;
        }

        // user_id ophalen uit het JWT token
        $userId = $this->getUserIdFromJwtRequest();

        // course_id ophalen uit de URL parameters via een helpermethode in de BaseController
        $courseId = $this->getIdFromUrlParameters($vars);
        
        // Controleren of het vak bestaat en van de ingelogde student is
        $course = $this->validateCourseOwnership($courseId, $userId);
        if (!$course)
        {
            return;
        }

        // Vak verwijderen via ICourseService
        $deletedCourse = $this->courseService->deleteCourse($courseId);
        if (!$deletedCourse)
        {
            // Als het vak niet verwijderd kon worden HTTP statuscode 500 (Internal Server Error) meegeven
            $this->jsonErrorResponse('Vak kon niet verwijderd worden', 500);
        }

        // Succesmelding tonen
        // HTTP statuscode 200 (OK) gebruiken
        $this->jsonSuccessResponse(['message' => 'Vak succesvol verwijderd!']);
    }

    // Helpermethodes //
    // Helpermethode om een vak op te halen en te controleren of het van de ingelogde student is
    private function validateCourseOwnership(int $courseId, int $userId): ?Course 
    {
        // Controleren of het vak bestaat
        $course = $this->courseService->getCourseByCourseId($courseId);
        if (!$course)
        {
            // HTTP statuscode 404 (Not Found) meegeven
            $this->jsonErrorResponse('Vak niet gevonden', 404);
            return null;
        }

        // Controleren of het vak van de ingelogde student is
        if ($course->getUserId() !== $userId)
        {
            // HTTP statuscode 403 (Forbidden) meegeven
            $this->jsonErrorResponse('Geen toegang tot dit vak', 403);
            return null;
        }

        // Vak teruggeven als het van de ingelogde student is
        return $course;
    }
}