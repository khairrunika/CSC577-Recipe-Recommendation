<?php
session_start();

// Allow from any origin
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Handle OPTIONS request for preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Database connection
$user = 'root';
$pass = '';
$conn = 'recipe_rocket';
$port = 3307; // Add this line to specify the port

$conn = new mysqli('localhost', $user, $pass, $conn, $port) or die("Unable to connect to database");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['password'])) {
    $username = $data['username'];
    $password = $data['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT admin_id, admin_password FROM admin WHERE admin_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $admin_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $admin_password)) {
            $_SESSION['admin_id'] = $admin_id;
            echo json_encode(["success" => true, "message" => "Login successful."]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No user found with that username."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Please enter both username and password."]);
}

$conn->close();
?>
