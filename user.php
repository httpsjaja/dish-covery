


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Dashboard</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome User!, <span id="username"></span>!</h1>

        <!-- Success/Error Messages -->
        <div id="message" class="message"></div>

        <!-- Profile Card -->
        <div class="profile-card">
            <img id="profileImage" src="uploads/default.png" alt="Profile Picture" class="profile-img">
            <h2 id="userEmail">user</h2>

            <!-- Image Upload Form -->
            <form id="uploadForm">
                <label for="profileImageInput">Update Profile Image:</label>
                <input type="file" id="profileImageInput" accept="image/*" required>
               <button id="deleteButton" style="display: none;">Delete Profile Picture</button>
        </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>

    <script src="user.js"></script>
</body>
</html>
