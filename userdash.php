<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$host = 'localhost';
$db   = 'dishcovery';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve recipes
$sql = "SELECT dish_name, recipe, category, image_path FROM recipe";
$result = $conn->query($sql);

// Store recipes in an array
$recipes = [];
if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $image_path = !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : 'images/default-image.jpg';
            if (!file_exists($image_path)) {
                $image_path = 'images/default-image.jpg';
            }

            $recipes[] = [
                'dish_name' => htmlspecialchars($row['dish_name']),
                'recipe' => nl2br(htmlspecialchars($row['recipe'])),
                'category' => htmlspecialchars($row['category']),
                'image_path' => $image_path,
            ];
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="userdash.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="userdash.js" defer></script>
</head>
<body>
    <aside class="sidebar">
        <h2>Dish-covery</h2>
        <div class="horizontal-line"></div>
        <main>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Type to search..." oninput="filterRecipes()">
                <button onclick="filterRecipes()">Search</button>
            </div>
        </main>
        <div class="btnn-container">
            <button class="btnn btnn-color-2" onclick="window.location.href='nutridash.php'">Nutrition Tracker</button>
            <button class="btnn btnn-color-3" onclick="window.location.href='mealplan.php'">Meal Planning</button>
        </div>
        <div class="btn1-container">
            <button class="btn1 btn1-color-4" onclick="window.location.href='upload.php'">Upload Recipe</button>
            <button class="btn1 btn1-color-5" onclick="window.location.href='user.php'">Profile</button>
        </div>
        <div class="logout-container">
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </aside>
    <div class="container mt-5">
        <h2>Uploaded Recipes</h2>
        <div class="row" id="recipeContainer">
            <?php if (!empty($recipes)): ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col-md-4 mb-4 recipe-card">
                        <div class="card">
                            <img src="<?= $recipe['image_path'] ?>" class="card-img-top" alt="<?= $recipe['dish_name'] ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $recipe['dish_name'] ?></h5>
                                <p class="card-text"><?= $recipe['recipe'] ?></p>
                                <p class="card-text"><small class="text-muted">Category: <?= $recipe['category'] ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No recipes found.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        // Logout function
        function logout() {
            window.location.href = 'login.php';
        }

        // JavaScript search function
        function filterRecipes() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const recipeCards = document.querySelectorAll('.recipe-card');

            recipeCards.forEach(card => {
                const dishName = card.querySelector('.card-title').innerText.toLowerCase();
                const recipeText = card.querySelector('.card-text').innerText.toLowerCase();

                if (dishName.includes(searchInput) || recipeText.includes(searchInput)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
