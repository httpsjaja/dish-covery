document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const fileInput = document.getElementById('profileImageInput');
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const profileImage = document.getElementById('profileImage');
            const deleteButton = document.getElementById('deleteButton');
            const message = document.getElementById('message');

            // Update the profile image source and display it
            profileImage.src = e.target.result;
            profileImage.alt = 'Updated Profile Picture';
            profileImage.style.display = 'block';
            
            // Show success message
            message.textContent = 'Profile picture updated successfully!';
            message.className = 'message success';

            // Show delete button
            deleteButton.style.display = 'block';
        };

        reader.readAsDataURL(file);
        fileInput.value = ''; // Clear the input
    }
});

// Delete profile picture functionality
document.getElementById('deleteButton').addEventListener('click', function() {
    const profileImage = document.getElementById('profileImage');
    const deleteButton = document.getElementById('deleteButton');
    const message = document.getElementById('message');

    // Reset the profile picture to default
    profileImage.src = 'uploads/default.png';
    profileImage.alt = 'Profile Picture';
    
    // Show success message
    message.textContent = 'Profile picture deleted successfully!';
    message.className = 'message success';
    
    // Hide delete button
    deleteButton.style.display = 'none';
});
