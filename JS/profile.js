// profile.js

function toggleForm() {
    var editForm = document.getElementById('editForm');
    var editButton = document.getElementById('editButton');
    var userDetails = document.querySelectorAll('span');

    if (editForm.style.display === 'none') {
        editForm.style.display = 'block';
        editButton.style.display = 'none';

        // Hide the user details when the form is displayed
        userDetails.forEach(function (element) {
            element.style.display = 'none';
        });
    } else {
        editForm.style.display = 'none';
        editButton.style.display = 'inline';

        // Show the user details when the form is hidden
        userDetails.forEach(function (element) {
            element.style.display = 'inline';
        });
    }
}

// JavaScript function to save edited details
function saveDetails() {
    document.getElementById('editForm').action = 'http://imy.up.ac.za/u20426586/php/general/editProfile.php';
    document.getElementById('editForm').submit();
    toggleForm();
}

// JavaScript function to cancel the edit and hide the form
function cancelEdit() {
    document.getElementById('editForm').action = '';
    toggleForm();
}
