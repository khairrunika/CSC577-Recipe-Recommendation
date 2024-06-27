<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe Details - Recipe Rocket</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* Global styles */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f7fafc; /* Tailwind gray-100 */
    }

    /* Taskbar styles */
    .taskbar {
      background-color: #ebe5d6; /* Light beige */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .taskbar a {
      color: #4a5568; /* Tailwind gray-700 */
    }

    .taskbar a:hover {
      color: #1a202c; /* Tailwind gray-900 */
    }

    /* Main content styles */
    .recipe-details {
      max-width: 800px;
      margin: auto;
      padding: 1rem;
      background-color: #ffffff; /* White */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    .recipe-details h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #1a202c; /* Tailwind gray-900 */
      margin-bottom: 1rem;
    }

    .recipe-details .meta-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
      color: #4a5568; /* Tailwind gray-700 */
    }

    .recipe-details .meta-info div {
      flex: 1;
      text-align: center;
    }

    .recipe-details .ingredients {
      margin-bottom: 1rem;
    }

    .recipe-details .ingredients h2 {
      font-size: 1.5rem;
      font-weight: bold;
      color: #1a202c; /* Tailwind gray-900 */
      margin-bottom: 0.5rem;
    }

    .recipe-details .ingredients ul {
      list-style-type: disc;
      padding-left: 1.5rem;
    }

    .recipe-details .instructions {
      margin-bottom: 1rem;
    }

    .recipe-details .instructions h2 {
      font-size: 1.5rem;
      font-weight: bold;
      color: #1a202c; /* Tailwind gray-900 */
      margin-bottom: 0.5rem;
    }

    .recipe-details .instructions ol {
      list-style-type: decimal;
      padding-left: 2rem;
    }

    .recipe-details .instructions p {
      color: #718096; /* Tailwind gray-600 */
    }

    /* Footer styles */
    .footer {
      background-color: #f7fafc; /* Tailwind gray-100 */
      text-align: center;
      padding: 1rem 0;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

  <nav class="taskbar shadow-md p-4 flex justify-between items-center">
    <div class="text-2xl font-bold text-gray-800">Recipe Rocket</div>
    <div class="flex-1 flex justify-center space-x-6 text-lg">
      <a href="homepage.html" class="text-gray-600 hover:text-gray-900">Home</a>
      <a href="viewRecipe.html" class="text-gray-600 hover:text-gray-900">Recipe</a>
    </div>
    <div class="flex space-x-6 text-lg">
      <a href="manageSaveRecipe.html" class="text-gray-600 hover:text-gray-900 flex items-center">
        <img aria-hidden="true" alt="chef" src="img/chef.png" class="w-6 h-6 object-contain"/>
      </a>
      <a href="profile.html" class="text-gray-600 hover:text-gray-900 flex items-center">
        <img aria-hidden="true" alt="user" src="img/user.png" class="w-6 h-6 object-contain"/>
      </a>
      <a href="userLogin.html" class="text-gray-600 hover:text-gray-900 flex items-center">
        <img aria-hidden="true" alt="user" src="img/logout.png" class="w-6 h-6 object-contain"/>
      </a>
    </div>
  </nav>

  <div class="container mx-auto p-8 recipe-details">
    <?php
    // Include your database connection file here if necessary
    // Example: include 'db_connect.php';

    // Ensure recipe_id is provided and is numeric
    if (isset($_GET['recipe_id']) && is_numeric($_GET['recipe_id'])) {
      $recipe_id = $_GET['recipe_id'];

      // Placeholder for database connection and query
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "recipe_rocket";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare SQL statement to fetch recipe details based on recipe_id
      $sql = "SELECT * FROM recipe WHERE recipe_id = $recipe_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
          ?>
          <h1 class="text-4xl font-bold mb-4"><?php echo $row['recipe_name']; ?></h1>
          <div class="meta-info">
            <div>Cooking Time: <?php echo $row['recipe_cookingTime']; ?></div>
            <div>Calories: <?php echo $row['recipe_calories']; ?></div>
          </div>
          <div class="ingredients">
            <h2 class="text-xl font-semibold mb-2">Ingredients</h2>
            <ul class="list-disc">
              <?php
              // Split ingredients by comma and display as list items
              $ingredients = explode(",", $row['recipe_ingredient']);
              foreach ($ingredients as $ingredient) {
                echo "<li>$ingredient</li>";
              }
              ?>
            </ul>
          </div>
          <div class="instructions">
            <h2 class="text-xl font-semibold mb-2">Instructions</h2>
            <?php
            // Check if recipe_instructions key exists in $row before iterating
            if (!empty($row['recipe_cookingInstruction'])) {
              ?>
              <ol class="list-decimal">
                <?php
                // Split instructions by newline and display as ordered list items
                $instructions = explode("\n", $row['recipe_cookingInstruction']);
                foreach ($instructions as $instruction) {
                  echo "<li>$instruction</li>";
                }
                ?>
              </ol>
              <?php
            } else {
              echo "<p>Instructions not available.</p>";
            }
            ?>
          </div>
          <?php
        }
      } else {
        echo "<p>No recipe found with ID: $recipe_id</p>";
      }
      $conn->close();
    } else {
      echo "<p>Invalid recipe ID.</p>";
    }
    ?>
  </div>

  <div class="footer">
    <p>&copy; 2024 Recipe Rocket. All rights reserved.</p>
  </div>

</body>
</html>
