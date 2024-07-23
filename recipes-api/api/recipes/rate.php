<?php
include_once '../../db.php';

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method === 'GET') {
    try {
        $pdo = connect_db();
        $stmt = $pdo->query("SELECT id, title, rating FROM recipes");
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($recipes);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error fetching recipes: " . $e->getMessage()]);
    }
} elseif ($request_method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['id']) && !empty($data['rating'])) {
        try {
            $pdo = connect_db();
            $rating = max(1, min(5, intval($data['rating'])));

            $sql = "UPDATE recipes SET rating = :rating WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':id', $data['id']);

            if ($stmt->execute()) {
                echo json_encode(["message" => "Recipe rated successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Failed to rate recipe."]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error updating recipe: " . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Incomplete data."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}
?>