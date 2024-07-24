<?php
include_once '../../db.php';

if (isset($_GET['query'])) {
    $query = '%' . $_GET['query'] . '%';
    
    $pdo = connect_db();
    $sql = "SELECT * FROM recipes WHERE title LIKE :query OR ingredients LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':query', $query);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($recipes);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Query not provided."]);
}
?>
