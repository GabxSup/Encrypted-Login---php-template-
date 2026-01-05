<?php
// fix_db.php - Script de reparación automática
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';

echo "<h1>Reparación de Base de Datos</h1>";

try {
    // 1. Intentar crear tabla simple (sin FK conflictivas)
    $sql = "CREATE TABLE IF NOT EXISTS activity_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        email_attempt VARCHAR(255) NULL,
        action VARCHAR(50) NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        user_agent VARCHAR(255) NULL,
        details TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "<p style='color:green'>✔ Tabla activity_logs verificada/creada.</p>";

    // 2. Verificar si podemos escribir
    $stmt = $pdo->prepare("INSERT INTO activity_logs (action, ip_address, details) VALUES (?, ?, ?)");
    $stmt->execute(['test_repair', '127.0.0.1', 'Log de prueba exitoso']);
    echo "<p style='color:green'>✔ Escritura de prueba exitosa.</p>";

} catch (PDOException $e) {
    echo "<p style='color:red'>✘ Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='/login'>Ir al Login</a></p>";
