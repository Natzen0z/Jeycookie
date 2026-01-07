import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Global SweetAlert2 config
window.Swal = Swal;
Swal.fire.setDefaults({
    buttonsStyling: false,
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline',
        popup: 'rounded-lg',
    },
});

// Helper functions
window.showAlert = function(message, type = 'success') {
    Swal.fire({
        title: type.charAt(0).toUpperCase() + type.slice(1),
        text: message,
        icon: type,
        timer: 2000,
        timerProgressBar: true,
    });
};

window.confirmDelete = function(callback) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
};
