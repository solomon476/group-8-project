document.addEventListener('DOMContentLoaded', () => {
    // Client-side validation logic
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            let isValid = true;
            let errorMsg = '';

            // Specifically checking password match if on registration or reset form
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');

            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value) {
                    isValid = false;
                    errorMsg = "Passwords do not match!";
                } else if (password.value.length < 8) {
                    isValid = false;
                    errorMsg = "Password must be at least 8 characters long.";
                }
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission
                showError(form, errorMsg);
            }
        });
    });

    function showError(form, message) {
        // Remove existing alert if any
        let existingAlert = form.querySelector('.alert.error');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert error';
        alertDiv.textContent = message;

        form.insertBefore(alertDiv, form.firstChild);
    }
});
