<?php
session_start();
include_once '../../db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["message" => "Unauthorized access."]);
    exit;
}

// Retrieve input data
$title = isset($_POST['title']) ? $_POST['title'] : '';
$ingredients = isset($_POST['ingredients']) ? $_POST['ingredients'] : '';
$instructions = isset($_POST['instructions']) ? $_POST['instructions'] : '';

// Validate input data
if (empty($title) || empty($ingredients) || empty($instructions)) {
    http_response_code(400);
    echo json_encode(["message" => "Incomplete data."]);
    exit;
}

$pdo = connect_db();
$sql = "INSERT INTO recipes (title, ingredients, instructions) VALUES (:title, :ingredients, :instructions)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':ingredients', $ingredients);
$stmt->bindParam(':instructions', $instructions);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "Recipe created successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to create recipe."]);
}
?>
