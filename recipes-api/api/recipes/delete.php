<?php
include_once '../../db.php';

if (isset($_GET['id'])) {
    $pdo = connect_db();
    $sql = "DELETE FROM recipes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Recipe deleted successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to delete recipe."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "ID not provided."]);
}
?>
