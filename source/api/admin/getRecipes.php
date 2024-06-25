<?php
header('Content-Type: application/json');

// Database connection
$user = 'root';
$pass = '';
$conn = 'recipe_rocket';
$port = '3307';

$conn = new mysqli('localhost', $user, $pass, $conn, $port) or die("Unable to connect to database");


// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}
$sql = "SELECT r.recipe_id, r.recipe_name, r.recipe_cookingTime, c.cuisine_type, m.meal_type, r.recipe_calories
FROM recipe r
JOIN cuisine c ON r.cuisine_id = c.cuisine_id
JOIN meal m ON r.meal_id = m.meal_id;
";
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
