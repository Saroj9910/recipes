<?php
include_once '../../db.php';

$pdo = connect_db();
$sql = "SELECT * FROM recipes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($recipes);
?>
