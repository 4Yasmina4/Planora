<?php
namespace App\Repositories;

use PDO;
use App\Models\Course;
use App\Repositories\ICourseRepository;

class CourseRepository implements ICourseRepository
{
    private PDO $pdo;

    // Constructor die $pdo opslaat
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Methode die alle vakken ophaald van een specifieke student op basis van de user_id
    public function getAllCoursesByUserId(int $userId): array
    {
        // SQL-query voorbereiden om alle vakken op te halen van een specifieke student, gesorteerd op naam (A-Z).
        $stmt = $this->pdo->prepare("SELECT * FROM course WHERE user_id = :user_id ORDER BY course_name ASC");
        // Placeholder :user_id invullen met waarde van $userId. Dit voorkomt SQL-injectie
        $stmt->execute(['user_id' => $userId]);
        
        // Alle rijen ophalen als associatieve arrays
        // Een associatieve array bevat geen nummers maar namen als sleutels
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Array aanmaken om Course-objecten in op te slaan
        $courses = [];

        // Elk database-rij wordt omgezet naar Course-object en vervolgens toegevoegd aan de lijst
        foreach ($rows as $row)
        {
            $courses[] = $this->mapRowToCourseObject($row);
        }

        // Lijst met Course-objecten teruggeven
        return $courses;
    }

    // Methode die één specifieke vak ophaald op basis vaan de course_id
    public function getCourseByCourseId(int $courseId): ?Course
    {
        //SQL-query die 1 vak ophaalt op basis van course_id
        $stmt = $this->pdo->prepare("SELECT * FROM course WHERE course_id = :course_id");
        
        //Voert bovenstaande SQL-query uit en vult ':course_id' met waarde van $courseId
        $stmt->execute(['course_id' => $courseId]);

        //Haalt 1 rij uit database op als een associatieve array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Als er geen vak is gevonden, geeft de functie null terug
        if (!$row)
        {
            return null;
        }

        //Zet de opgehaalde databse-rij om naar een Course-Object
        return $this->mapRowToCourseObject($row);
    }
 
    // Methode om een nieuwe vak aan te maken
    public function createCourse(Course $course): Course
    {
        // SQL INSERT-query voorbereiden om een nieuwe vak aan te maken
        $stmt = $this->pdo->prepare("
                INSERT INTO course (user_id, course_name, course_description, ects, exam_date, study_material)
                VALUES (:user_id, :course_name, :course_description, :ects, :exam_date, :study_material)
        ");

        // INSERT-query uitvoeren met de waarden uit het Course-object
        $stmt->execute([
            'user_id' => $course->getUserId(),
            'course_name' => $course->getCourseName(),
            'course_description' => $course->getCourseDescription(),
            'ects' => $course->getEcts(),
            'exam_date' => $course->getExamDate(),
            'study_material' => $course->getStudyMaterial()
        ]);

        // Database genereert een nieuwe course_id; deze wordt gebruikt om een volledige Course-object terug te geven
        $courseId = (int)$this->pdo->lastInsertId();

        // Course-object aanmaken met nieuwe gegenereerde course_id via helpermethode
        return $this->mapCourseWithCourseId($course, $courseId);
    }

    // Methode om een vak te verwijderen op basis van de course_id
    // Deze methode geeft een bool terug, omdat na het verwijderen van een vak het handig is om te weten of dit is gelukt
    // Hierbij is het onnodig om een Course-object terug te geven
    public function deleteCourse(int $courseId): bool
    {
        // SQL DELETE-query voorbereiden om een vak te verwijderen op basis van de course_id
        // :course_id is een placeholder en voorkomt SQL-injectie
        $stmt = $this->pdo->prepare("DELETE FROM course WHERE course_id = :course_id");

        // SQL DELETE-query uitvoeren met de waarde van $courseId
        // Execute geeft 'true' terug als een vak succesvol verwijderd is en 'false' als dit niet het geval is
        return $stmt->execute(['course_id' => $courseId]);
    }

    // Helpermethodes //
    // private //

    // Methode dat een nieuwe Course-object aanmaakt met de door de database gegenereerde course_id
    private function mapCourseWithCourseId(Course $course, int $courseId): Course
    {
        return new Course(
            $courseId,
            $course->getUserId(),
            $course->getCourseName(),
            $course->getCourseDescription(),
            $course->getEcts(),
            $course->getExamDate(),
            $course->getStudyMaterial()
        );
    }

    // public //
    // Methode dat Course-objecten aanmaakt van de opgehaalde database gegevens
    public function mapRowToCourseObject(array $row): Course
    {
        return new Course(
            $row['course_id'],
            $row['user_id'],
            $row['course_name'],
            $row['course_description'],
            $row['ects'],
            $row['exam_date'],
            $row['study_material'],
            $row['created_at'],
            $row['updated_at'],
        );
    }

}