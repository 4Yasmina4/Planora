<?php
namespace App\Enums;

enum UserRole: string 
{
    //2 soorten gebruikers: 'administrator' en 'student'
    case ADMINISTRATOR = 'administrator';
    case STUDENT = 'student';
}