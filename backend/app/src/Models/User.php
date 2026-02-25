<?php
namespace App\Models;

use App\Enums\UserRole;
use JsonSerializable;

class User implements JsonSerializable {
    //Private attributen voor veiligheidsredenen
    private ?int $userId; //null alleen toegestaan bij het aanmaken van een nieuwe user, omdat deze nog door de database gegenereerd moet worden
    private string $firstName;
    private ?string $surnamePrefix; //null toegestaan
    private string $lastName;
    private string $email;
    private string $password;
    private UserRole $userRole;


    public function __construct(?int $userId, string $firstName, ?string $surnamePrefix, string $lastName, string $email, string $password, UserRole $userRole)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->surnamePrefix = $surnamePrefix;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->userRole = $userRole;
    }

    //Getters
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getSurnamePrefix(): ?string
    {
        return $this->surnamePrefix;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserRole(): UserRole
    {
        return $this->userRole;
    }

    // Bepalen welke data omgezet woord naar JSON formaat en teruggestuurd wordt naar de frontend
    // Wachtwoord wordt bewust weggelaten uit veiligheidsredenen
    public function jsonSerialize(): array 
    {
        // Een associatieve array terugsturen met de gegevens van de user.
        // Een associatieve array is een array waarbij elke waarde een naam (key) heeft in plaats van een getal as index
        return [
            'user_id' => $this->userId,
            'first_name' => $this->firstName,
            'surname_prefix' => $this->surnamePrefix,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'role' => $this->userRole->value //value wordt gebruikt zodat er een string wordt teruggegeven en geen enum object
        ];
    }
}