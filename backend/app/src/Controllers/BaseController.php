<?php
namespace App\Controllers;

class BaseController
{
    // Een success JSON response terugsturen naar de frontend
    // Er wordt een HTTP statuscode 200 (OK) gegeven; Verzoek is gelukt, data wordt teruggestuurd naar frontend
    // Er wordt een array of object van data teruggegeven
    protected function jsonSuccessResponse(array|object $data, int $httpStatusCode = 200): void 
    {
        // HTTP statuscode instellen (200 in dit geval) die wordt meegestuurd naar de frontend
        http_response_code($httpStatusCode);

        // Aangeven dat de response JSON data bevat
        header('Content-Type: application/json');

        // Zet PHP data om naar JSON formaat en stuurt het daarna met echo naar de frontend
        echo json_encode($data);
    }

    
    // Een error JSON response terugsturen naar de frontend
    // Er wordt een HTTP statuscode 400 (Bad Request) gegeven; Verkeerde of ontbrekende data is meegestuurd
    // Er wordt een string teruggegeven
    protected function jsonErrorResponse(string $errorMessage, int $httpStatusCode = 400): void 
    {
        // HTTP statuscode instellen (400 in dit geval) die wordt meegestuurd naar de frontend
        http_response_code($httpStatusCode);

        // Aangeven dat de response JSON data bevat
        header('Content-Type: application/json');

        // De foutmelding in een array met een 'error' key wikkelen
        // Frontend kan hierdoor altijd op dezelfde plek de foutmelding vinden
        // De array wordt omgezet naar JSON formaat en wordt naar de frontend gestuurd
        echo json_encode(['error' => $errorMessage]);
    }

    // JSON data ophalen uit de request body die de frontend meestuurt
    // De request body is de data die meegestuurd wordt in het verzoek van de frontend naar de backend
    // Kan null teruggeven als er geen data wordt meegestuurd
    protected function getJsonDataFromRequestBody(): ?array
    {
        // Ruwe JSON string uit de request body lezen via php://input
        // Zet deze om naar een PHP associatieve array via json_decode
        // 'true' als tweede parameter zorgt ervoor dat het resultaat een associatieve array wordt in plaats van een object
        return json_decode(file_get_contents('php://input'), true);
    }

    // Controleren of alle verplichte invoervelden ingevuld zijn in de request data 
    // True teruggeven als alle verplichte invoervelden zijn ingevuld, false als niet alle verplichte invoervelden ingevuld zijn
    protected function validateRequiredFormFields(array $formData, array $requiredFormFields): bool 
    {
        // Voor elk invoerveld van een formulier geldt:
        foreach ($requiredFormFields as $formField)
        {
            if (empty($formData[$formField]))
            {
                // False; niet alle verplichte invoervelden zijn ingevuld
                return false;
            }
        }

        // True; alle verplichte invoervelden zijn ingevuld
        return true;
    }

    // URL-parameter ophalen uit de route-parameters en omzetten naar een integer
    // $vars is een array die door FastRoute wordt aangemaakt op basis van de URL
    // Bijvoorbeeld: /users/5 → $vars = ['id' => 5] → geeft 5 terug als integer 
    protected function getIdFromUrlParameters(array $vars): int
    {
        return (int)$vars['id'];
    }
}