<?php
namespace App\Repositories;

use PDO;
use App\Models\User;
use App\Enums\UserRole;

class UserRepository
{
    private PDO $pdo;

    // Constructor die $pdo opslaat
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Methode om alle gebruikers op te halen
    public function getAllUsers(): array
    {
        // SQL-query uitvoeren om alle gebruikers op te halen, gesorteerd op voornaam (A-Z).
        $stmt = $this->pdo->query("SELECT * FROM user ORDER BY first_name ASC");
        
        // Alle rijen ophalen als associatieve arrays
        // Een associatieve array bevat geen nummers maar namen als sleutels
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Array aanmaken om User-objecten in op te slaan
        $users = [];

        // Elk database-rij wordt omgezet naar User-object en vervolgens toegevoegd aan de lijst
        foreach ($rows as $row)
        {
            $users[] = $this->mapRowToUser($row);
        }

        // Lijst met User-objecten teruggeven
        return $users;

    }

    // Methode om één gebruiker op te halen op basis van de userId
    public function getUserByUserId(int $userId): ?User
    {
        //SQL-query die 1 gebruiker ophaalt op basis van user_id
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE user_id = :user_id");
        
        //Voert bovenstaande SQL-query uit en vult '?' met waarde van $userId
        $stmt->execute(['user_id' => $userId]);

        //Haalt 1 rij uit database op als een associatieve array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Als er geen gebruiker is gevonden, geeft de functie null terug
        if (!$row)
        {
            return null;
        }

        //Zet de opgehaalde databse-rij om naar een User-Object, met behulp van mapRowToUser methode uit de UserRepository
        return $this->mapRowToUser($row);
    }

    // Methode om gebruiker op te halen op basis van hun email
    // Nodig voor het inloggen
    // Terugwaarde van deze methode is ?User. Het geeft een gebruiker terug als deze bestaat en null als dit niet het geval is
    public function getUserByEmail(string $email): ?User
    {
        // SQL-query die 1 gebruiker ophaalt op basis van email
        // :email is een placeholder en voorkomt SQL-injectie
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");

        // SQL-query uitvoeren met de waarde van $email
        $stmt->execute(['email' => $email]);

        // 1 rij ophalen uit de database al een associatieve array
        // Een associatieve array is een array waarbij elke waarde een naam (key) heeft in plaats van een getal als index
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Als er geen gebruiker is gevonden voor dit e-mailadres, geeft de functie null terug
        if (!$row)
        {
            return null;
        }

        // mapRowToUser methode aanroepen om de opgehaalde database-rij om te zetten naar een User-object
        return $this->mapRowToUser($row);
    }

    // Methode om gebruiker aan te maken
    public function createUser(User $user): User
    {
        // SQL INSERT-query voorbereiden om een nieuwe gebruiker aan te maken
        $stmt = $this->pdo->prepare("
                INSERT INTO user (first_name, surname_prefix, last_name, email, password, role)
                VALUES (:first_name, :surname_prefix, :last_name, :email, :password, :role)
        ");

        // INSERT-query uitvoeren met de waarden uit het User-object
        $stmt->execute([
            'first_name' => $user->getFirstName(),
            'surname_prefix' => $user->getSurnamePrefix(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getUserRole()->value
        ]);

        // Database genereert een nieuwe user_id; deze wordt gebruikt om een volledige User-object terug te geven
        $userId = (int)$this->pdo->lastInsertId();

        // User-object aanmaken met nieuwe gegenereerde user_id via helpermethode
        return $this->mapUserWithUserId($user, $userId);
    }
    
    // Methode om gebruikergegevens te wijzigen
    // Op basis van de userId worden de gegevens van een gebruiker gewijzigd
    public function updateUser(int $userId, string $firstName, ?string $surnamePrefix, string $lastName, string $email, ?string $hashedPassword, UserRole $userRole): User
    {
        //Wachtwoord wijzigen is optioneel
        if (!empty($hashedPassword))
        {
            //Wachtwoord wel wijzigen
            //Ingevoerde gegevevens van fomrulier toevoegen aan de user-tabel in de database
            $stmt = $this->pdo->prepare("UPDATE user
                                        SET first_name = :first_name, surname_prefix = :surname_prefix, last_name = :last_name, email = :email, password = :password, role = :role
                                        WHERE user_id = :user_id");

            $stmt->execute(['first_name' => $firstName, 'surname_prefix' => $surnamePrefix, 'last_name' => $lastName, 'email' => $email, 'password' => $hashedPassword, 'role' => $userRole->value, 'user_id' => $userId]);
        } else {
            //Wachtwoord wordt niet gewijzigd
            $stmt = $this->pdo->prepare("UPDATE user
                                        SET first_name = :first_name, surname_prefix = :surname_prefix, last_name = :last_name, email = :email, role = :role
                                        WHERE user_id = :user_id");

            $stmt->execute(['first_name' => $firstName, 'surname_prefix' => $surnamePrefix, 'last_name' => $lastName, 'email' => $email, 'role' => $userRole->value, 'user_id' => $userId]);
        }

        // Gewijzigde gebruiker opnieuw ophalen uit de database en teruggeven
        return $this->getUserByUserId($userId);
    }

    // Methode om een gebruiker te verwijderen op basis van de user_id
    // Deze methode geeft een bool terug, omdat na het verwijderen van een gebruiker het handig is om te weten of dit is gelukt
    // Hierbij is het onnodig om een User-object terug te geven
    public function deleteUser(int $userId): bool
    {
        // SQL DELETE-query voorbereiden om een gebruiker te verwijderen op basis van de user_id
        // :user_id is een placeholder en voorkomt SQL-injectie
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE user_id = :user_id");

        // SQL DELETE-query uitvoeren met de waarde van $userId
        // Execute geeft 'true' terug als een gebruiker succesvol verwijderd is en 'false' als dit niet het geval is
        return $stmt->execute(['user_id' => $userId]);
    }


    // Helpermethodes //
    // private //

    private function mapUserWithUserId(User $user, int $userId): User
    {
        return new User(
            $userId,
            $user->getFirstName(),
            $user->getSurnamePrefix(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getUserRole()
        );
    }

    // public //
    // Methode dat User-objecten aanmaakt van de opgehaalde database gegevens.
    public function mapRowToUser(array $row): User
    {
        return new User(
            $row['user_id'],
            $row['first_name'],
            $row['surname_prefix'],
            $row['last_name'],
            $row['email'],
            $row['password'],
            UserRole::from($row['role']),
        );
    }
}