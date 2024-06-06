<?php
header('Content-Type: application/json');

// Database connection
$user = 'root';
$pass = '';
$conn = 'recipe_rocket';

$conn = new mysqli('localhost', $user, $pass, $conn) or die("Unable to connect to database");


// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}
$sql = "SELECT recipe_name, recipe_cookingTime, recipe_cuisineType, recipe_mealType, recipe_dietaryTag, recipe_calories FROM recipe";
$result = $conn->query($sql);

$recipes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

echo json_encode($recipes);

$conn->close();
?>
