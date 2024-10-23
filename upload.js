document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    // Get form values
    const dishName = document.getElementById('photoTitle').value;
    const description = document.getElementById('photoDescription').value;
    const category = document.getElementById('category').value;
    const photo = document.getElementById('photo').files[0];

    // Create a FileReader to display the image
    const reader = new FileReader();
    reader.onload = function(e) {
        // Create a recipe object
        const recipe = {
            id: Date.now(), // Unique ID for each recipe
            dishName,
            description,
            category,
            photo: e.target.result // Image as a base64 string
        };

        // Store the recipe in local storage
        const recipes = JSON.parse(localStorage.getItem('recipes')) || [];
        recipes.push(recipe);
        localStorage.setItem('recipes', JSON.stringify(recipes));

        // Show success message
        const messageDiv = document.getElementById('message');
        messageDiv.textContent = 'Recipe uploaded successfully! Waiting for admin approval.';

        // Clear the form fields
        document.getElementById('uploadForm').reset();
    };

    // Read the image file as a Data URL
    if (photo) {
        reader.readAsDataURL(photo);
    }
});