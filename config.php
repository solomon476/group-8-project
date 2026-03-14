<?php
// config.php - Updated for InfinityFree Live Hosting
$db_host = 'sql210.infinityfree.com';
$db_user = 'if0_41386588';
$db_pass = 'M6WJC9JRv12Av';
$db_name = 'if0_41386588_group8';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
