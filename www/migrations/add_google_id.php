<?php

require_once __DIR__ . '/../config/database.php';

try {
    // Add google_id column if not exists
    $pdo->exec("
        ALTER TABLE users 
        ADD COLUMN IF NOT EXISTS google_id VARCHAR(255) NULL UNIQUE
    ");
    echo "¡Columna google_id agregada con éxito!";
} catch (PDOException $e) {
    echo "Info: " . $e->getMessage(); // It might fail if exists or other DB issues, but largely fine to ignore if strict SQL is not needed
}
