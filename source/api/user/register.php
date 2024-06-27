<?php
	include "config.php";
	
	//define all required information
	if(isset($_POST["register"])){
		
		$username = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phoneNum"];
		$password = $_POST["pass"];
		$confirmPassword = $_POST["confirmPass"];
		
		//SQL command or query
		$sql = "SELECT * FROM consumer WHERE consumer_username = '$username'";
		
		//Send SQL command to MySQL using database connection
		$sendsql = mysqli_query($connect, $sql);
		
		//check if SQL successfully sent
		if($sendsql){
			//check if there are rows that matches the given condition
			if(mysqli_num_rows($sendsql) > 0){
				echo "<script> 
							alert('Username already exist. Please insert another username');
					  </script>";
			}
			else{
				if($password == $confirmPassword)
				{
					$sql = "INSERT INTO consumer (consumer_username, consumer_email, consumer_phoneNumber, consumer_password) 
							  VALUES ('$username','$email','$phone','$password')";
				
					$sendsql = mysqli_query($connect, $sql);
				
					if($sendsql){
						echo "<script> 
								alert('Congrats! Your registration was successful!');
								window.location.href='index.php';
							  </script>";
					}
					else{
						echo "<script> 
								alert('Sorry, your registration failed. Please try again!');
							  </script>";
					}
				}
				else{
					echo "<script> 
								alert('Password not match!');
						  </script>";
				}
			}
		}
	}
?>