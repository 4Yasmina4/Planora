<?php

// Haalt de Origin header op uit het verzoek (adres van frontend)
// Als Orgin header niet bestaat, wordt een lege string gebruikt
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Controleren of het verzoek afkomstig is van de localhost 
// Dit voorkomt dat andere website verzoeken kunnen versturen naar de backend
if (preg_match('/^https?:\/\/(localhost|127\.0\.0\.1|::1)(:\d+)?$/', $origin)) {
    // Verzoeken toestaan van de frontend op de localhost
    header('Access-Control-Allow-Origin: ' . $origin);

    // Aangeven welke HTTP methodes toegestaan zijn (GET, POST, PUT, DELETE, OPTIONS)
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

    // Geeft aan welke HTTP headers meegestuurd mogen worden in het verzoek
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

    // Cookies en inloggevens toestaan die worden meegestuurd met het verzoek
    header('Access-Control-Allow-Credentials: true');

    // Aangeven hoelang de browser de CORS instellingen mag onthouden (86400 seconden = 24 uur)
    // CORS (Cross-Origin Resource Sharing) - staat verzoeken toe van de frontend op de localhost 
    header('Access-Control-Max-Age: 86400');
}

// Controleren of de browser het verzoek wel mag versturen
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // HTTP code 200 (OK) sturen, als het verzoek is goedgekeurd
    http_response_code(200);
    exit;
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../Config/Database.php'; // Zorgt ervoor dat $pdo beschikbaar is
require __DIR__ . '/../Config/Dependencies.php'; // Zorgt ervoor dat de controllers met bijbehorende methodes beschikbaar zijn

use function FastRoute\simpleDispatcher;

// Routes laden vanuit het bestand Routes.php
$routes = require __DIR__ . '/../Config/Routes.php';
$dispatcher = simpleDispatcher($routes);


// Request afhandelen
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    // Route niet gevonden
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Route niet gevonden.']);
        break;

    // Route waarbij verkeerde HTTP methode wordt aangeroepen
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['error' => 'Methode niet toegestaan.']);
        break;

    // Afhandeling van gevonden route
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller->$method($vars);
        break;
}