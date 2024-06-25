<?php
header('Content-Type: application/json');

// Database connection
$user = 'root';
$pass = '';
$dbname = 'recipe_rocket';
$port = '3307';

// Create connection
$conn = new mysqli('localhost', $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);
$recipeId = $data['recipe_id'] ?? null;

if (!$recipeId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid recipe ID']);
    exit();
}

// Prepare the SQL delete statement
$stmt = $conn->prepare("DELETE FROM recipe WHERE recipe_id = ?");
$stmt->bind_param("i", $recipeId);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Recipe deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete recipe']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
