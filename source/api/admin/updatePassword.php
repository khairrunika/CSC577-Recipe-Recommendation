<?php
// Database connection
$user = 'root';
$pass = '';
$conn = 'recipe_rocket';
$port = 3307; // Add this line to specify the port

$conn = new mysqli('localhost', $user, $pass, $conn, $port) or die("Unable to connect to database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$password = '4dmin!@#'; // Your plain text password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE admin SET admin_password='$hashed_password' WHERE admin_username='admin1'";

if ($conn->query($sql) === TRUE) {
    echo "Password updated successfully";
} else {
    echo "Error updating password: " . $conn->error;
}

$conn->close();
?>
