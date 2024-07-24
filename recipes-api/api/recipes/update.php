<?php
ob_start();

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../db.php';

// Function to get input data from a PUT request
function get_input_data() {
    $data = file_get_contents("php://input");
    return json_decode($data, true);
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $data = get_input_data();

    if (!empty($data['id']) && (!empty($data['title']) || !empty($data['ingredients']) || !empty($data['instructions']))) {
        try {
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
                http_response_code(200);
                echo json_encode(["message" => "Recipe updated successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Failed to update recipe."]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "An error occurred: " . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Incomplete data."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}
// Flush the output buffer
ob_end_flush();
?>
