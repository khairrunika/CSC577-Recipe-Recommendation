<?php
	// Database credentials
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbname = "recipe_rocket";

	// Establishing connection to the database
	$connect = new mysqli($hostname, $username, $password, $dbname);

	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$recipe_id = $_GET['recipe_id'];
	$recipe = null;

	if (isset($recipe_id)) {
		// Fetch recipe details
		$sql = "SELECT * FROM recipe WHERE recipe_id = $recipe_id";
		$result = mysqli_query($connect, $sql);

		if ($result) {
			$recipe = mysqli_fetch_assoc($result);
		}
	}

	if (isset($_POST['editRecipe'])) {
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

		$filesExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($filesExt));

		// pick what type of file allowed
		$allowed = array('jpg', 'pdf', 'png');

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 1000000) {
					$fileNameNew = uniqid('', true) . "." . $fileActualExt;
					$fileDestination = 'Uploads/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);

					$sql = "UPDATE `recipe` SET `recipe_name`='$recipe_name', `recipe_ingredient`='$ingredients', `recipe_cookingInstruction`='$cooking_instructions', `recipe_cookingTime`='$cooking_time', `recipe_calories`='$calories', `recipe_photo`='$fileDestination', `cuisine_id`='$cuisine_id', `meal_id`='$meal_id' WHERE `recipe_id`='$recipe_id'";

					$sendsql = mysqli_query($connect, $sql);

					if ($sendsql) {
						echo "<script> 
									alert('Recipe updated successfully.');
									window.location.href='/Recipe_Rocket/source/view/Admin/ListOfRecipes.html';
							  </script>";
					} else {
						echo "<script> 
									alert('Sorry, recipe update failed!');
							  </script>";
					}
				} else {
					echo "<script> 
								alert('Your file is too big!');
						  </script>";
				}
			} else {
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
    <title>Recipe Rocket - Edit Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7F7F7;
            margin: 0;
            padding: 0;
        }

        .textarea-large {
            height: 125px;
        }

        .textarea-large-instruc {
            height: 300px;
        }

        .textarea-small {
            height: 80px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 5px);
            right: 0;
            z-index: 10;
            width: 120px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 12px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
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
		<h1 class="text-3xl font-bold mb-6">Edit Recipe Details</h1>
		<form action="" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
			<div class="grid grid-cols-2 gap-6">
				<div class="flex flex-col space-y-4">
					<div>
						<label class="block text-gray-700 font-bold mb-2">Recipe name:</label>
						<input type="text" name="recipe_name" value="<?php echo $recipe['recipe_name']; ?>" class="w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
					</div>
					<div>
						<label class="block text-gray-700 font-bold mb-2">Cooking time:</label>
						<input type="text" name="cooking_time" value="<?php echo $recipe['recipe_cookingTime']; ?>" class="w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
					</div>
					<div>
						<label class="block text-gray-700 font-bold mb-2">Cuisine types:</label>
						<select name="cuisine_types" class="w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
							<?php
							$sql = "SELECT * FROM cuisine";
							$result = $connect->query($sql);
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<option value='" . $row['cuisine_id'] . "' " . ($row['cuisine_id'] == $recipe['cuisine_id'] ? 'selected' : '') . ">" . $row['cuisine_type'] . "</option>";
								}
							}
							?>
						</select>
					</div>
					<div>
						<label class="block text-gray-700 font-bold mb-2">Meal types:</label>
						<select name="meal_types" class="w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
							<?php
							$sql = "SELECT * FROM meal";
							$result = $connect->query($sql);
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<option value='" . $row['meal_id'] . "' " . ($row['meal_id'] == $recipe['meal_id'] ? 'selected' : '') . ">" . $row['meal_type'] . "</option>";
								}
							}
							?>
						</select>
					</div>
					<div>
						<label class="block text-gray-700 font-bold mb-2">Calories:</label>
						<input type="text" name="calories" value="<?php echo $recipe['recipe_calories']; ?>" class="w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
					</div>
					<div>
						<label class="block text-gray-700 font-bold mb-2">Recipe image:</label>
						<div class="flex items-center space-x-4">
							<div>
								<img src="<?php echo $recipe['recipe_photo']; ?>" alt="Recipe Image" class="mt-2 w-32 h-32 object-cover rounded-lg">
							</div>
							<div class="flex-1">
								<input type="file" name="file" class="w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
							</div>
						</div>
					</div>
				</div>
				<div class="flex flex-col space-y-4">
					<div>
						<label class="block text-gray-700 font-bold mb-2">Ingredients:</label>
						<textarea name="ingredients" class="textarea-large w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required><?php echo $recipe['recipe_ingredient']; ?></textarea>
					</div>
					<div>
						<label class="block text-gray-700 font-bold mb-2">Cooking instructions:</label>
						<textarea name="cooking_instructions" class="textarea-large-instruc w-full p-3 border border-gray-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required><?php echo $recipe['recipe_cookingInstruction']; ?></textarea>
					</div>
				</div>
			</div>
			<div class="flex justify-between mt-4">
				<button type="submit" name="editRecipe" class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg hover:bg-green-700">Update Recipe</button>
				<a href="ListOfRecipes.html" class="px-4 py-2 bg-gray-500 text-white font-bold rounded-lg hover:bg-gray-700">Back</a>
			</div>
		</form>
	</div>
</body>
</html>