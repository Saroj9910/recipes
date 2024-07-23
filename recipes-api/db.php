<?php
function connect_db() {
    $host = 'localhost';
    $db = 'recipes_db';
    $user = 'root'; // Change this as per your database user
    $pass = '';     // Change this as per your database password

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}
?>
