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

// Process search query
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // SQL query to search for recipes
    $sql = "SELECT * FROM recipe WHERE recipe_name LIKE '%" . $searchQuery . "%'";

    $result = $conn->query($sql);

    $recipes = array();

    if ($result->num_rows > 0) {
        // Fetch associative array
        while($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }

    // Output JSON encoded results
    header('Content-Type: application/json');
    echo json_encode($recipes);
}

// Close connection
$conn->close();
?>
