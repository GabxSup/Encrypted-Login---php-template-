<?php

require_once __DIR__ . '/../www/config/database.php';
require_once __DIR__ . '/../www/models/User.php';

function test_pagination()
{
    echo "\nTesting Pagination Logic...\n";
    $userModel = new User();

    // 1. Seed Dummy Data (if needed)
    $currentCount = $userModel->count();
    $targetCount = 25;

    if ($currentCount < $targetCount) {
        echo "Seeding database with dummy users (Current: $currentCount, Target: $targetCount)...\n";
        $needed = $targetCount - $currentCount;
        for ($i = 0; $i < $needed; $i++) {
            $random = bin2hex(random_bytes(4));
            $userModel->create([
                'name' => "User $random",
                'email' => "user_$random@example.com",
                'password' => 'password123',
                'password_confirm' => 'password123'
            ]);
        }
    }

    // 2. Test Page 1 (Limit 10, Offset 0)
    $page1 = $userModel->all(10, 0);
    if (count($page1) === 10) {
        echo "[PASSED] Page 1 fetched 10 users correctly.\n";
    } else {
        echo "[FAILED] Page 1 fetched " . count($page1) . " users (Expected 10).\n";
    }

    // 3. Test Page 3 (Limit 10, Offset 20) -> Should have 5 users if total is 25
    $page3 = $userModel->all(10, 20);
    // Note: It might be more if DB already had users. Just checking we get *some* results and not more than limit.
    $countPage3 = count($page3);
    if ($countPage3 > 0 && $countPage3 <= 10) {
        echo "[PASSED] Page 3 fetched valid number of users ($countPage3).\n";
    } else {
        echo "[FAILED] Page 3 fetched $countPage3 users.\n";
    }
}

try {
    echo "====== Starting Efficiency Verification ======\n";
    test_pagination();
    echo "\n====== Verification Complete ======\n";
} catch (Exception $e) {
    echo "Error during testing: " . $e->getMessage() . "\n";
}
