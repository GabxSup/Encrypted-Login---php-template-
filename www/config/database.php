<?php

$host = getenv('DB_HOST') ?: 'mariadb';
$port = getenv('DB_PORT') ?: '3306';
$db = getenv('DB_NAME') ?: 'appdb';
$user = getenv('DB_USER') ?: 'appuser';
$pass = getenv('DB_PASS') ?: 'apppass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // 🛡️ Seguridad: No mostrar detalles del error al usuario
    error_log('DB Error: ' . $e->getMessage()); // Loguear error interno
    die('Error de conexión con la base de datos. Por favor intente más tarde.');
}

