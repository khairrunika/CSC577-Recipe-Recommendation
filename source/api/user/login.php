<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$user = 'root';
$pass = '';
$db = 'recipe_rocket';
$port = 3306;

$conn = new mysqli('localhost', $user, $pass, $db, $port);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['password'])) {
    $username = $data['username'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT consumer_id, consumer_username, consumer_password FROM consumer WHERE consumer_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($consumer_id, $consumer_username, $consumer_password);
        $stmt->fetch();

        if (password_verify($password, $consumer_password)) {
            $_SESSION['consumer_id'] = $consumer_id;
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
