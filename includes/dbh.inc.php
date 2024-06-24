<?php
require_once __DIR__ . '/../config.php';

$dbhost = $_ENV['DB_HOST'];
$dbuser = $_ENV['DB_USER'];
$dbpass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];


try {
    // Create a new PDO instance
    $dsn = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulated prepared statements
    ];

    $pdo = new PDO($dsn, $dbuser, $dbpass, $options);

    // echo "Successfully connected to the database! \n";
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
