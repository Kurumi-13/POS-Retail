<?php
declare(strict_types=1);

$host = 'localhost';
$dbname = 'ermie_lito_pos';
$dbuser = 'root';
$dbpass = ''; // Default XAMPP MySQL password is often blank. Change if yours is different.

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Check includes/db.php and make sure MySQL is running in XAMPP.');
}
