<?php
// Include the database connection file
require_once "../../connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $password = $_POST['pass'];
    $confirmPassword = $_POST['confirmPass'];
    $preferences = "None"; // Example default value for preferences

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match!');
                window.location.href = '../../view/user/register.html';
              </script>";
        exit;
    }

    // Prepare SQL query to insert data into consumer table
    $sql = "INSERT INTO consumer (consumer_username, consumer_email, consumer_phoneNumber, consumer_password, consumer_preferences) 
            VALUES (?, ?, ?, ?, ?)";
    
    // Use prepared statements for security and to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $email, $phoneNum, $password, $preferences);
    
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
