<?php
include_once '../../db.php';

$pdo = connect_db();
$errors = [];

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM recipes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
} elseif (isset($_GET['title'])) {
    $sql = "SELECT * FROM recipes WHERE title = :title";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $_GET['title']);
} else {
    $errors[] = "ID or Title not provided.";
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(["message" => "Incomplete data.", "errors" => $errors]);
    exit;
}

$stmt->execute();
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if ($recipe) {
    header('Content-Type: application/json');
    echo json_encode($recipe);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Recipe not found."]);
}
?>
