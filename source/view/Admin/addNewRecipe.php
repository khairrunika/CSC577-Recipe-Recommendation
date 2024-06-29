<?php							
	// Database credentials
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbname = "recipe_rocket";
	
	// Establishing connection to the database
	$connect = new mysqli($hostname, $username, $password, $dbname);
	
	if (!$connect) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}
	
	if(isset($_POST['addRecipe'])){
		//getting data
		$recipe_name = $_POST['recipe_name'];
		$cooking_time = $_POST['cooking_time'];
		$cuisine_id = $_POST['cuisine_types']; 
		$meal_id = $_POST['meal_types']; 
		$calories = $_POST['calories'];
		$file = $_FILES['file'];
		$ingredients = $_POST['ingredients'];
		$cooking_instructions = $_POST['cooking_instructions'];

		// getting file info
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];
		
		$filesExt = explode('.',$fileName);
		$fileActualExt = strtolower(end($filesExt));
		
		// pick wht type of file allowed
		$allowed = array('jpg','pdf', 'png');
		
		if(in_array($fileActualExt, $allowed)){
			if($fileError === 0){
				if($fileSize < 1000000)
				{	
								
						$fileNameNew = uniqid('', true).".".$fileActualExt;
						$fileDestination = 'Uploads/'.$fileNameNew;
						move_uploaded_file($fileTmpName, $fileDestination);
					
						$sql = "INSERT INTO `recipe`(`recipe_name`, `recipe_ingredient`, `recipe_cookingInstruction`, `recipe_cookingTime`, `recipe_calories`, `recipe_photo`, `cuisine_id`, `meal_id`) 
								VALUES ('$recipe_name','$ingredients','$cooking_instructions','$cooking_time', '$calories','$fileDestination', '$cuisine_id','$meal_id')";
						
						$sendsql = mysqli_query($connect, $sql);
		
						if($sendsql)
						{	
							echo "<script> 
										alert('New recipe added successfully.');
								  </script>";
										
						}
						else 
							echo "<script> 
										alert('Sorry, new recipe failed to added!');
								  </script>";
					
				} else{
					echo "<script> 
								alert('Your file is too big!');
						  </script>";
				}
			}else{
				echo "<script> 
							alert('There was an error uploading your file!');
					  </script>";
			} 
				
		} else {
			echo "<script> 
						alert('You cannot upload this type of file!');
				  </script>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Recipe Rocket - Insert New Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7F7F7;
            margin: 0;
            padding: 0;
        }
        .textarea-large {
            height: 125px; /* Adjust this value as needed */
        }
        .textarea-large-instruc {
            height: 300px;
        }
        .textarea-small {
            height: 80px; /* Adjust this value as needed */
        }
        /* Custom styles for the dropdown */
        .dropdown {
            position: relative;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 5px);
            right: 0;
            z-index: 10;
            width: 120px; /* Adjust width as needed */
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dropdown-menu a {
            display: block;
            padding: 8px 12px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center; /* Center align text */
        }
        .dropdown-menu a:hover {
            background-color: #f0f0f0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const dropdownIcon = document.getElementById('dropdownIcon');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            dropdownIcon.addEventListener('click', (e) => {
                e.preventDefault();
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            });

            // Close the dropdown if the user clicks outside of it
            window.addEventListener('click', (e) => {
                if (!dropdownIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });
        });
    </script>
</head>
<body class="bg-gray-100">
    <nav class="shadow-md p-4 flex justify-between items-center" style="background-color: #ebe5d6;">
        <div class="text-2xl font-bold text-black-600">Recipe Rocket</div>
        <div class="space-x-4">
            <a href="Dashboard.html" class="text-gray-700 hover:text-purple-600 transition">Dashboard</a>
            <a href="#" class="text-gray-700 hover:text-purple-600 transition">Recipe</a>
        </div>
        <div class="relative">
            <div class="dropdown">
                <a href="" id="dropdownIcon" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <img aria-hidden="true" alt="user" src="../../../assets/images/user.png" class="w-6 h-6 object-contain"/>
                </a>
                <div class="dropdown-menu absolute bg-white rounded-md shadow-lg z-20">
                    <a href="../Admin/adminProfile.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                    <a href="../../api/admin/logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-10 px-6">
        <h1 class="text-3xl font-bold mb-6">Insert New Recipe</h1>
        <form action="" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <div class="grid grid-cols-2 gap-6">
                <div class="flex flex-col space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold">Enter recipe name</label>
                        <input type="text" name="recipe_name" class="w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Enter cooking time</label>
                        <input type="text" name="cooking_time" class="w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Enter cuisine types</label>
                        <select name="cuisine_types" class="w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="">Select cuisine type</option>
                            <?php
                                // PHP code to fetch cuisine types from database
                                $hostname = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "recipe_rocket";

                                // Create connection
                                $connect = new mysqli($hostname, $username, $password, $dbname);

                                // Check connection
                                if ($connect->connect_error) {
                                    die("Connection failed: " . $connect->connect_error);
                                }

                                // Fetch cuisine types with IDs
                                $sql = "SELECT * FROM cuisine";
                                $result = $connect->query($sql);

                                if (!$result) {
                                    echo "Error: " . $connect->error;
                                } else {
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['cuisine_id'] . "'>" . $row['cuisine_type'] . "</option>";
                                        }
                                    } else {
                                        echo "No cuisine types found.";
                                    }
                                }

                                $connect->close();
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Enter meal types</label>
                        <select name="meal_types" class="w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="">Select meal type</option>
                            <?php
                                // PHP code to fetch meal types from database
                                $hostname = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "recipe_rocket";

                                // Create connection
                                $connect = new mysqli($hostname, $username, $password, $dbname);

                                // Check connection
                                if ($connect->connect_error) {
                                    die("Connection failed: " . $connect->connect_error);
                                }

                                // Fetch meal types with IDs
                                $sql = "SELECT * FROM meal";
                                $result = $connect->query($sql);

                                if (!$result) {
                                    echo "Error: " . $connect->error;
                                } else {
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['meal_id'] . "'>" . $row['meal_type'] . "</option>";
                                        }
                                    } else {
                                        echo "No meal types found.";
                                    }
                                }

                                $connect->close();
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Enter calories</label>
                        <input type="text" name="calories" class="w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Enter images</label>
                        <input type="file" name="file" class="w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                </div>
                <div class="flex flex-col space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold">Enter ingredients</label>
                        <textarea name="ingredients" class="textarea-large w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Enter cooking instructions</label>
                        <textarea name="cooking_instructions" class="textarea-large-instruc w-full p-2 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required></textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="submit" name="addRecipe" class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg hover:bg-green-700">Add Recipe</button>
                <a href="../Admin/ListOfRecipes.html" class="px-4 py-2 bg-gray-500 text-white font-bold rounded-lg hover:bg-gray-700">Back</a>
            </div>
        </form>
    </div>
</body>
</html>