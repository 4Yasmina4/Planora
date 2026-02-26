<?php

// variabelen uit .env bestand halen
$databaseType = getenv('DB_TYPE');
$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// DNS samenstellen
$dsn = "$databaseType:host=$host;dbname=$dbname;charset=utf8mb4";

//PDO connectie maken
try{
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Unable to connect to the database." . $e->getMessage());
}