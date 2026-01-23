<?php

require_once __DIR__ . '/../www/config/database.php';
require_once __DIR__ . '/../www/core/RateLimiter.php';
require_once __DIR__ . '/../www/models/User.php';

function test_sql_injection()
{
    echo "\nTesting SQL Injection Vulnerability...\n";
    $user = new User();

    // Attempt malicious input
    $malicious_email = "' OR '1'='1";
    $result = $user->findByEmail($malicious_email);

    if ($result) {
        echo "[FAILED] SQL Injection might be possible (User found via injection).\n";
    } else {
        echo "[PASSED] SQL Injection test passed (No user found via injection).\n";
    }
}

function test_input_validation()
{
    echo "\nTesting Input Validation...\n";
    $user = new User();

    // Test invalid email
    $invalid_data = [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirm' => 'password123'
    ];

    $result = $user->create($invalid_data);

    if (!$result) {
        echo "[PASSED] Invalid email rejected.\n";
    } else {
        echo "[FAILED] Invalid email accepted.\n";
    }
}

function test_rate_limiting()
{
    echo "\nTesting Rate Limiting...\n";
    $limiter = new RateLimiter();
    $current_ip = '127.0.0.1'; // Simulate local IP

    // Clear previous attempts for clean test
    $limiter->clearAttempts($current_ip);

    // Simulate 12 attempts (limit is 10)
    echo "Simulating 12 attempts...\n";
    for ($i = 0; $i < 12; $i++) {
        $limiter->logAttempt($current_ip);
    }

    if ($limiter->isBlocked($current_ip)) {
        echo "[PASSED] IP Blocked after excessive attempts.\n";
    } else {
        echo "[FAILED] Rate Limiting failed to block IP.\n";
    }

    // Cleanup
    $limiter->clearAttempts($current_ip);
}

try {
    echo "====== Starting Security Verification ======\n";
    test_sql_injection();
    test_input_validation();
    test_rate_limiting();
    echo "\n====== Verification Complete ======\n";
} catch (Exception $e) {
    echo "Error during testing: " . $e->getMessage() . "\n";
}
