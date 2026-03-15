<?php
namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Services\ICourseService;
use App\Services\IAuthenticationService;

class CourseController extends BaseController
{
    // Readonly zorgt ervoor dat de property na de constructor niet meer gewijzigd kan worden
    private readonly ICourseService $courseService;

    // CourseService via dependency injection meegeven
    public function __construct(ICourseService $courseService, IAuthenticationService $authenticationService)
    {
        $this->courseService = $courseService;
        // AuthenticationService doorgeven aan de BaseController via parent constructor
        parent::__construct($authenticationService);
    }

    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(): void
    {
        // user_id ophalen en controleren of de gebruiker ingelogd is via een helpermethode in de BaseController
        $userId = $this->validateUserAuthentication();

        // Als er geen geldig user_id is, is de gebruiker niet ingelogd
        if (!$userId)
        {
            // Foutmelding wordt al verstuurd in de methode validateUserAuthentication in de BaseController
            // Functie stoppen
            return;
        }
        
        // Alle vakken ophalen via de ICourseService
        $courses = $this->courseService->getAllCoursesByUserId($userId);

        // Lijst met vakken terugsturen naar de frontend
        $this->jsonSuccessResponse($courses);
    }

    // Methode om een nieuwe vak aan te maken
    public function createCourse(): void
    {
        // user_id ophalen en controleren of de gebruiker ingelogd is via een helpermethode in de BaseController
        $userId = $this->validateUserAuthentication();

        // Als er geen geldig user_id is, is de gebruiker niet ingelogd
        if (!$userId)
        {
            // Foutmelding wordt al verstuurd in de methode validateUserAuthentication in de BaseController
            // Functie stoppen
            return;
        }

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
}