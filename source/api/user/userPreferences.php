<?php
	include "config.php";

	// Check if consumer_id is set in the session
	if (isset($_SESSION["consumer_id"])) {
		$consumer_id = $_SESSION["consumer_id"];
	} else {
		echo "<script>
				alert('User is not logged in. Please log in first.');
				window.location.href='index.php'; // Redirect to login/index page
			  </script>";
		exit();
	}

	// Check if preferences are already set
	$sql_check = "SELECT consumer_preferences FROM consumer WHERE consumer_id = '$consumer_id'";
	$result_check = mysqli_query($connect, $sql_check);
	$row_check = mysqli_fetch_assoc($result_check);

	if (!empty($row_check['consumer_preferences'])) {
		echo "<script>
				window.location.href='homepage.html'; // Redirect to homepage or relevant page
			  </script>";
		exit();
	}

	if (isset($_POST["preferences_submit"])) {
		// Check if preferences are set and not empty
		if (isset($_POST["preferences"]) && !empty($_POST["preferences"])) {
			$preferences = $_POST["preferences"];
			$preferences_str = implode(",", $preferences);
		} else {
			$preferences_str = "";
		}

		$sql = "UPDATE consumer SET consumer_preferences = '$preferences_str' WHERE consumer_id = '$consumer_id'";
		$sendsql = mysqli_query($connect, $sql);

		if ($sendsql) {
			echo "<script> 
					alert('Preferences updated successfully!');
					window.location.href='/recipe_rocket/source/view/User/homepage.html'; // Redirect to dashboard or relevant page
				  </script>";
		} else {
			echo "<script> 
					alert('Failed to update preferences. Please try again!');
				  </script>";
		}

		// Close the connection
		mysqli_close($connect);
	}
?>