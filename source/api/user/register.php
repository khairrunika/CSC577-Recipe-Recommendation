<?php
// Include the database connection file
require_once "../../connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // $password = $_POST['pass'];
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password for security
    $preferences = "None"; // Example default value for preferences



    // Prepare SQL query to insert data into consumer table
    $sql = "INSERT INTO consumer (consumer_username, consumer_email, consumer_phoneNumber, consumer_password, consumer_preferences) 
            VALUES (?, ?, ?, ?, ?)";
    
    // Use prepared statements for security and to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $email, $phoneNum, $hashed_password, $preferences);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to homepage and show success message
        echo "<script>
                alert('Registration successful!');
                window.location.href = '../../view/user/homepage.html';
              </script>";
        exit;
    } else {
        // Handle SQL execution error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

