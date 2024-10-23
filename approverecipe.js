function approveRecipe(recipeId) {
    fetch('approve_recipe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: recipeId, status: 'approved' }),
    })
    .then(response => {
        if (response.ok) {
            alert(`Recipe ${recipeId} approved.`);
            loadRecipes(); // Reload the recipes to reflect changes
        } else {
            alert('Failed to approve recipe.');
        }
    });
}
