<?php
session_start();

// Database connection (adjust as per your configuration)
$user = 'root';
$pass = '';
$dbname = 'recipe_rocket';
$port = 3306;

$conn = new mysqli('localhost', $user, $pass, $dbname, $port) or die("Unable to connect to database");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT consumer_id, consumer_username FROM consumer WHERE consumer_username = '$username' AND consumer_password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Fetch the consumer details
        $row = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['consumer_id'] = $row['consumer_id'];
        $_SESSION['consumer_username'] = $row['consumer_username'];

        // Debug: Output session variables
        // echo json_encode(['status' => 'success', 'message' => 'Login successful', 'session' => $_SESSION]);

        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}

// Close the connection
mysqli_close($conn);
?>
