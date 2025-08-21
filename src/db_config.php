<?php

$host = 'db';
$dbname = 'user_management';
$user = 'user';
$password = 'password';
$port = 5432;

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Database connection error: Please try again later.");
}