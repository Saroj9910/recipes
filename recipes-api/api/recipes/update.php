<?php
include_once '../../db.php';

// Function to get input data from a PUT request
function get_input_data() {
    $data = file_get_contents("php://input");
    return json_decode($data, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $data = get_input_data();

    if (!empty($data['id']) && (!empty($data['title']) || !empty($data['ingredients']) || !empty($data['instructions']))) {
        $pdo = connect_db();
        $sql = "UPDATE recipes SET 
                    title = COALESCE(:title, title), 
                    ingredients = COALESCE(:ingredients, ingredients), 
                    instructions = COALESCE(:instructions, instructions) 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':ingredients', $data['ingredients']);
        $stmt->bindParam(':instructions', $data['instructions']);
        $stmt->bindParam(':id', $data['id']);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Recipe updated successfully."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to update recipe."]);
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
