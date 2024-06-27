<?php
// Create connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "recipe_rocket";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the consumer ID (replace with the actual consumer ID)
$consumer_id = 1; // Replace with the actual consumer ID

// Fetch the saved recipes by consumer
$sql = "SELECT r.recipe_id, r.name 
        FROM saved_recipe sr
        JOIN recipe r ON sr.recipe_id = r.recipe_id
        JOIN consumer c ON sr.consumer_id = c.consumer_id
        WHERE sr.consumer_id = $consumer_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $saved_recipes = array();
    while($row = $result->fetch_assoc()) {
        $saved_recipes[] = $row;
    }
} else {
    $saved_recipes = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Recipe Rocket - Saved Recipes</title>
</head>
<body class="bg-gray-100">
    <nav class="shadow-md p-4 flex justify-between items-left" style="background-color: #ebe5d6;">
        <div class="text-2xl font-bold text-black-600">Recipe Rocket</div>
        <div class="space-x-4">
            <a href="homepage
