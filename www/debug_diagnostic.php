<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "=== INICIO DIAGNÓSTICO ===\n";

// 1. Check File System
echo "\n[1] Verificando archivos críticos...\n";
$files = [
    'config/database.php',
    'controllers/HomeController.php',
    'views/home.php',
    'assets/css/style.css',
    'core/Logger.php'
];
foreach ($files as $f) {
    if (file_exists(__DIR__ . '/' . $f)) {
        echo "OK: $f existe.\n";
    } else {
        echo "ERROR: $f NO existe.\n";
    }
}

// 2. Check Database Connection
echo "\n[2] Verificando Base de Datos...\n";
try {
    require_once __DIR__ . '/config/database.php';
    echo "OK: Conexión establecida.\n";

    // Check Users Table
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "OK: Tabla 'users' existe.\n";
        $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo "Info: Hay $count usuarios registrados.\n";
    } else {
        echo "ERROR: Tabla 'users' NO existe.\n";
    }

    // Check Activity Logs Table
    $stmt = $pdo->query("SHOW TABLES LIKE 'activity_logs'");
    if ($stmt->rowCount() > 0) {
        echo "OK: Tabla 'activity_logs' existe.\n";

        // Check columns
        $columns = $pdo->query("DESCRIBE activity_logs")->fetchAll(PDO::FETCH_COLUMN);
        echo "Columnas en activity_logs: " . implode(", ", $columns) . "\n";

        // Try insert
        try {
            $testStmt = $pdo->prepare("INSERT INTO activity_logs (action, ip_address, details) VALUES ('debug_test', '127.0.0.1', 'Testing log')");
            $testStmt->execute();
            echo "OK: Insert en 'activity_logs' exitoso.\n";
        } catch (Exception $e) {
            echo "ERROR: Falló insert de prueba: " . $e->getMessage() . "\n";
        }

    } else {
        echo "ERROR: Tabla 'activity_logs' NO existe.\n";

        // Try to create it manually here to see error
        echo "Intentando crear tabla 'activity_logs'...\n";
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS activity_logs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NULL,
                    email_attempt VARCHAR(255) NULL,
                    action VARCHAR(50) NOT NULL,
                    ip_address VARCHAR(45) NOT NULL,
                    user_agent VARCHAR(255) NULL,
                    details TEXT NULL,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
                )
            ");
            echo "OK: Tabla creada exitosamente durante diagnóstico.\n";
        } catch (PDOException $e) {
            echo "ERROR FATAL creando tabla: " . $e->getMessage() . "\n";
        }
    }

} catch (Exception $e) {
    echo "ERROR CRÍTICO DB: " . $e->getMessage() . "\n";
}

// 3. Check PHP Syntax of Home View
echo "\n[3] Verificando sintaxis de vistas...\n";
$output = shell_exec('php -l ' . __DIR__ . '/views/home.php');
echo "Home View Syntax: $output";

echo "\n=== FIN DIAGNÓSTICO ===\n";
