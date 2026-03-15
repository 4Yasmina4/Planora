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