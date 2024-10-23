<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$host = 'localhost';
$db = 'dishcovery';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dish_name = trim($_POST['dish_name']);
    $recipe = trim($_POST['recipe']);
    $category = trim($_POST['category']);

    // Handle the uploaded file
    $target_dir = "uploads/";
    $image = $_FILES['photo']['name'];
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;

    // Check if the file is an image
    $check = getimagesize($_FILES['photo']['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit: 5MB)
    if ($_FILES['photo']['size'] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only specific image formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Upload file if no errors occurred
    if ($uploadOk) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Prepare SQL statement to insert recipe with 'pending' status
            $sql = "INSERT INTO recipe (dish_name, recipe, category, image_path, status) 
                    VALUES (?, ?, ?, ?, 'pending')";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssss", $dish_name, $recipe, $category, $target_file);

                if ($stmt->execute()) {
                    echo "New recipe added successfully.";
                    header("Location: admin.php");
                    exit();
                } else {
                    echo "Error executing statement: " . $stmt->error; // Debugging output
                }
                $stmt->close();
            } else {
                echo "Failed to prepare the statement: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, your file was not uploaded.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="upload.css"> <!-- Link to your CSS file -->
    <title>Upload Recipe</title>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Recipe</h2>
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="photoTitle">Dish name:</label>
                <input type="text" id="photoTitle" name="photoTitle" required>
            </div>

            <div class="form-group">
                <label for="photoDescription">Recipe and Procedure:</label>
                <textarea id="photoDescription" name="photoDescription" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="appetizer">Appetizer</option>
                    <option value="main_course">Main Course</option>
                    <option value="dessert">Dessert</option>
                    <option value="snack">Snack</option>
                    <option value="salads">Salads</option>
                    <option value="side_dishes">Side Dishes</option>
                </select>
            </div>

            <div class="form-group">
                <label for="photo">Select Photo:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>
            
            <button type="submit">Upload</button>
        </form>
        <div id="message" style="margin-top: 20px; color: green;"></div> <!-- Notification area -->
    </div>

    <script src="upload.js"></script> <!-- Link to your JavaScript file -->
</body>
</html>