<?php
// src/db.php
// Load credentials from environment or hard-code for now:
$dbHost = 'localhost';
$dbName = 'lostfound';
$dbUser = 'your_db_user';
$dbPass = 'your_db_pass';

try {
    // Use PDO for safe queries
    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // In production, log this instead:
    die("Database connection failed: " . $e->getMessage());
}
