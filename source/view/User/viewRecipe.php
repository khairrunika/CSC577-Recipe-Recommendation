<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "recipe_rocket"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an empty array to hold recipes
$recipes = array();

// Process search query
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // SQL query to search for recipes based on recipe_name or recipe_ingredient
    $sql = "SELECT * FROM recipe WHERE recipe_name LIKE ? OR recipe_ingredient LIKE ?";
    
    $stmt = $conn->prepare($sql);
    $likeQuery = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch associative array
        while($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
