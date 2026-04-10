<?php
namespace App\Repositories;

use PDO;
use App\Models\Progress;
use App\Repositories\IProgressRepository;

class ProgressRepository implements IProgressRepository
{
    private PDO $pdo;

    // Constructor die $pdo opslaat
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Methode die voortgang van één student ophaalt op basis van de user_id
    public function getProgressByUserId(int $userId): array
    {
        // SQL-query voorbereiden om de voortgang per vak op te halen van een specifieke student.
        // Via een LEFT JOIN worden taken gekoppeld aan vakken, zodat vakken zonder taken ook worden meegenomen.
        $stmt = $this->pdo->prepare("SELECT c.course_id, c.course_name, COUNT(t.task_id) as total_tasks, SUM(t.is_completed) as completed_tasks        
                                     FROM course c
                                     LEFT JOIN task t ON c.course_id = t.course_id
                                     WHERE c.user_id = :user_id 
                                     GROUP BY c.course_id, c.course_name");

        // Placeholder :user_id invullen met waarde van $userId. Dit voorkomt SQL-injectie
        $stmt->execute(['user_id' => $userId]);
        
        // Alle rijen ophalen als associatieve arrays
        // Een associatieve array bevat geen nummers maar namen als sleutels
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Array aanmaken om Progress-objecten in op te slaan
        $progresses = [];

        // Elk database-rij wordt omgezet naar Progress-object en vervolgens toegevoegd aan de lijst
        foreach ($rows as $row)
        {
            $progresses[] = $this->mapRowToProgressObject($row);
        }

        // Lijst met Progress-objecten teruggeven
        return $progresses;
    }

    
    // Helpermethodes //
    // Methode dat Progress-objecten aanmaakt van de opgehaalde database gegevens
    public function mapRowToProgressObject(array $row): Progress
    {
        return new Progress(
            (int)$row['course_id'],
            $row['course_name'],
            (int)$row['total_tasks'],
            (int)$row['completed_tasks'],
        );
    }
}