Banawa Trixie
function approveRecipe(recipeId) {
    const recipes = JSON.parse(localStorage.getItem('recipes')) || [];
    const updatedRecipes = recipes.map(recipe => {
        if (recipe.id === recipeId) {
            recipe.status = 'approved'; // Set status to approved
            // Optionally, you can add logic here to move the recipe to a separate approved list if needed
        }
        return recipe;
    });
    localStorage.setItem('recipes', JSON.stringify(updatedRecipes));
    alert(Recipe ${recipeId} approved.);
    updateUserDash(recipes); // Call to update user dashboard
}

function rejectRecipe(recipeId) {
    const recipes = JSON.parse(localStorage.getItem('recipes')) || [];
    const updatedRecipes = recipes.filter(recipe => recipe.id !== recipeId);
    localStorage.setItem('recipes', JSON.stringify(updatedRecipes));
    alert(Recipe ${recipeId} rejected and removed.);
    updateUserDash(updatedRecipes); // Call to update user dashboard
}

function updateUserDash(recipes) {
    const userRecipes = recipes.filter(recipe => recipe.status === 'approved');
    localStorage.setItem('userRecipes', JSON.stringify(userRecipes));
}