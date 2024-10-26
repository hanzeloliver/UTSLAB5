// script.js

// Function to confirm deletion of a to-do list
function confirmDeleteList() {
    return confirm("Are you sure you want to delete this to-do list?");
}

// Function to confirm deletion of a task
function confirmDeleteTask() {
    return confirm("Are you sure you want to delete this task?");
}

// Add event listeners to delete buttons (if they exist)
document.addEventListener("DOMContentLoaded", function() {
    const deleteListButtons = document.querySelectorAll('.delete-list');
    const deleteTaskButtons = document.querySelectorAll('.delete-task');

    deleteListButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirmDeleteList()) {
                event.preventDefault(); // Prevent the default action if the user cancels
            }
        });
    });

    deleteTaskButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirmDeleteTask()) {
                event.preventDefault(); // Prevent the default action if the user cancels
            }
        });
    });
});