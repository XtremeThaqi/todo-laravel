// Show success notification
function showSuccessAlert(message) {
    Swal.fire({
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        position: "top-end",
        toast: true,
        background: "#1e1e1e",
        color: "#ffffff",
    });
}

// Confirm and handle delete action
function confirmDelete(form) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#bb86fc",
        cancelButtonColor: "#8a8a8a",
        confirmButtonText: "Yes, delete it!",
        background: "#1e1e1e",
        color: "#ffffff",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.todo-checkbox input[type="checkbox"]').forEach(checkbox => {
        const todoId = checkbox.id.replace('checkbox-', '');
        const title = document.getElementById(`title-${todoId}`);
        title.classList.toggle('completed', checkbox.checked);
    });
});