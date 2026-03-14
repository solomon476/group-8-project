<?php
// config.php - Database connection configuration
$db_host = 'localhost';
$db_user = 'root'; // Change if required
$db_pass = ''; // Change if required
$db_name = 'secure_login_system';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
