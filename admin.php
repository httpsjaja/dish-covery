<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div id="message" class="alert" style="display: none;"></div>
        <div class="logout-container">
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
        <div class="horizontal-line"></div>
    </div>
    
    <div class="container mt-5">
        <h2>Uploaded Recipes</h2>
        <div class="row" id="recipeContainer">
            <!-- Recipe cards will be inserted here -->
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = 'login.php';
        }

        // Load recipes from local storage
        document.addEventListener('DOMContentLoaded', function() {
            loadRecipes();
        });

        function loadRecipes() {
            const recipes = JSON.parse(localStorage.getItem('recipes')) || [];
            const recipeContainer = document.getElementById('recipeContainer');
            recipeContainer.innerHTML = '';

            recipes.forEach(recipe => {
                const card = document.createElement('div');
                card.className = 'col-md-4 mb-4';
                card.innerHTML = `
                    <div class="card">
                        <img src="${recipe.photo}" class="card-img-top" alt="${recipe.dishName}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">${recipe.dishName}</h5>
                            <p class="card-text">${recipe.description}</p>
                            <p class="card-text"><small class="text-muted">Category: ${recipe.category}</small></p>
                            <button class="btn btn-success" onclick="approveRecipe('${recipe.id}')">Approve</button>
                            <button class="btn btn-danger" onclick="rejectRecipe('${recipe.id}')">Reject</button>
                        </div>
                    </div>
                `;
                recipeContainer.appendChild(card);
            });
        }

        function approveRecipe(recipeId) {
            const recipes = JSON.parse(localStorage.getItem('recipes')) || [];
            const updatedRecipes = recipes.map(recipe => {
                if (recipe.id === recipeId) {
                    recipe.status = 'approved'; // Set status to approved
                }
                return recipe;
            });

            // Save updated recipe list in localStorage
            localStorage.setItem('recipes', JSON.stringify(updatedRecipes));

            // Update the user dashboard with only approved recipes
            const approvedRecipes = updatedRecipes.filter(recipe => recipe.status === 'approved');
            localStorage.setItem('userRecipes', JSON.stringify(approvedRecipes));

            // Show success message and reload the page to refresh the admin view
            alert(`Recipe ${recipeId} approved.`);
            loadRecipes(); // Reload the recipes to reflect changes dynamically
        }

        function rejectRecipe(recipeId) {
            const recipes = JSON.parse(localStorage.getItem('recipes')) || [];
            const updatedRecipes = recipes.map(recipe => {
                if (recipe.id === recipeId) {
                    recipe.status = 'rejected'; // Set status to rejected
                }
                return recipe;
            });
            localStorage.setItem('recipes', JSON.stringify(updatedRecipes));

            // Update user dashboard and profile with rejected recipe
            updateUserDash(updatedRecipes);
            
            // Show rejection message
            alert(`Recipe ${recipeId} rejected and removed.`);
            loadRecipes(); // Reload the recipes to reflect changes dynamically
        }

        function updateUserDash(recipes) {
            const approvedRecipes = recipes.filter(recipe => recipe.status === 'approved');
            const rejectedRecipes = recipes.filter(recipe => recipe.status === 'rejected');
            
            // Update userRecipes in localStorage
            localStorage.setItem('userRecipes', JSON.stringify(approvedRecipes));
            // Optionally, store rejected recipes separately in user profile or another array
            localStorage.setItem('rejectedRecipes', JSON.stringify(rejectedRecipes));
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
