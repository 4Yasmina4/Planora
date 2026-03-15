<?php
namespace App\Repositories;

use App\Models\Course;

interface ICourseRepository
{

    // Methode om een nieuwe vak aan te maken
    public function createCourse(Course $course): Course;
}