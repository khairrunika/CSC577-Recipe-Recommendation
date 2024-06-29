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
        .dropdown:hover .dropdown-menu {
            display: block;
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
                <a href="#" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <img aria-hidden="true" alt="user" src="../../../assets/images/user.png" class="w-6 h-6 object-contain"/>
                </a>
                <div class="dropdown-menu absolute bg-white rounded-md shadow-lg z-20">
                    <a href="\view\Admin\adminProfile.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-10 px-6">
        <h1 class="text-3xl font-bold mb-6">Insert New Recipe</h1>
        <form action="" method="post" class="bg-white p-6 rounded shadow-md">
            <div class="grid grid-cols-2 gap-6">
                <div class="flex flex-col space-y-4">
                    <div>
                        <label class="block text-gray-700">Enter recipe name</label>
                        <input type="text" name="recipe_name" class="w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Enter cooking time</label>
                        <input type="text" name="cooking_time" class="w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Enter cuisine types</label>
                        <select name="cuisine_types" class="w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="">Select cuisine type</option>
                            <?php
								// PHP code to fetch cuisine types from database
								$hostname = "localhost";
								$username = "root";
								$password = "";
								$dbname = "recipe_rocket";

								// Create connection
								$conn = new mysqli($hostname, $username, $password, $dbname);

								// Check connection
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}

								// Fetch cuisine types
								$sql = "SELECT cuisine_type FROM cuisine";
								$result = $conn->query($sql);

								if (!$result) {
									echo "Error: " . $conn->error;
								} else {
									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo "<option value='" . $row['cuisine_type'] . "'>" . $row['cuisine_type'] . "</option>";
										}
									} else {
										echo "No cuisine types found.";
									}
								}

								$conn->close();
							?>
                        </select>
					</div>
                    <div>
                        <label class="block text-gray-700">Enter meal types</label>
                        <select name="meal_types" class="w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="">Select meal type</option>
                            <?php
								// PHP code to fetch meal types from database
								$conn_meal = new mysqli($hostname, $username, $password, $dbname);

								// Check connection
								if ($conn_meal->connect_error) {
									die("Connection failed: " . $conn_meal->connect_error);
								}

								// Fetch meal types
								$sql_meal = "SELECT meal_type FROM meal";
								$result_meal = $conn_meal->query($sql_meal);

								if ($result_meal->num_rows > 0) {
									while ($row_meal = $result_meal->fetch_assoc()) {
										echo "<option value='" . $row_meal['meal_type'] . "'>" . $row_meal['meal_type'] . "</option>";
									}
								} else {
									echo "No meal types found.";
								}

								$conn_meal->close();
                            ?>
                        </select>
					</div>
                    <div>
                        <label class="block text-gray-700">Enter calories</label>
                        <input type="text" name="calories" class="w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Enter images</label>
                        <input type="file" name="images" class="w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                    </div>
                </div>
                <div class="flex flex-col space-y-4">
                    <div>
                        <label class="block text-gray-700">Enter ingredients</label>
                        <textarea name="ingredients" class="textarea-large w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700">Enter cooking instructions</label>
                        <textarea name="cooking_instructions" class="textarea-large-instruc w-full p-2 border border-gray-300 rounded-none mt-1 focus:outline-none focus:ring-2 focus:ring-yellow-500" required></textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="submit" name="addRecipe" class="px-4 py-2 bg-green-500 text-white font-bold rounded-none hover:bg-green-700">Add Recipe</button>
                <a href="listOfRecipe.html" class="px-4 py-2 bg-gray-500 text-white font-bold rounded-none hover:bg-gray-700">Back</a>
            </div>
        </form>
    </div>
</body>
</html>