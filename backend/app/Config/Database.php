<?php

// .env bestand inlezen
$env = parse_ini_file(__DIR__ . '/../.env');

// variabelen uit .env bestand halen
$databaseType $env['DB_TYPE'];
$host = $env['DB_HOST'];
$username = $env['DB_USERNAME'];
$password = $env['DB_PASSWORD'];
$dbname = $env['DB_NAME'];

// DNS samenstellen
$dsn = "$type:host=$host;dbname=$dbname;charset=utf8mb4";

//PDO connectie maken
try{
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Unable to conntect to the database.")
}