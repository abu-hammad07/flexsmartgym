document.addEventListener('DOMContentLoaded', function () {
    // Function to validate numeric input fields
    function validateNumericInput(inputElement, errorElement) {
        inputElement.addEventListener('input', function () {
            const inputValue = inputElement.value.trim();
            const numericValue = inputValue.replace(/\D/g, ''); // Remove non-numeric characters

            if (inputValue !== numericValue) { // If non-numeric characters are present
                errorElement.textContent = '';
                errorElement.style.display = 'block';
                inputElement.classList.add('is-invalid');
            } else {
                errorElement.textContent = ''; // Clear error message
                errorElement.style.display = 'none';
                inputElement.classList.remove('is-invalid');
            }

            // Update the input value with the cleaned numeric value
            inputElement.value = numericValue;
        });

        // Ensure error message is displayed on initial load if there's an invalid value
        if (inputElement.value.trim() !== inputElement.value.replace(/\D/g, '')) {
            errorElement.textContent = '';
            errorElement.style.display = 'block';
            inputElement.classList.add('is-invalid');
        }
    }

    // Validate phone number input
    const phoneInput = document.getElementById('phone_no');
    const phoneError = document.getElementById('phone_no_error');
    validateNumericInput(phoneInput, phoneError);

    // Validate age input
    const ageInput = document.getElementById('age');
    const ageError = document.getElementById('age_error');
    validateNumericInput(ageInput, ageError);

    // Validate salary input
    const salaryInput = document.getElementById('monthly_fees');
    const salaryError = document.getElementById('erorr_monthly_fees');
    validateNumericInput(salaryInput, salaryError);
});



// ======================== username lowercase only  ======================
document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('username');
    const usernameError = document.getElementById('username_err');

    usernameInput.addEventListener('input', function () {
        let inputValue = usernameInput.value.trim();

        // Convert input value to lowercase
        inputValue = inputValue.toLowerCase();
        usernameInput.value = inputValue;

        // Check if input value is empty
        if (inputValue === '') {
            usernameError.textContent = '';
            usernameError.style.display = 'block';
            usernameInput.classList.add('is-invalid');
        }
        // Check if input value contains characters other than lowercase letters, '.', '-', '_'
        else if (!/^[a-z._-]+$/.test(inputValue)) {
            usernameError.textContent = 'Username should contain only lowercase letters, ".", "-", or "_".';
            usernameError.style.display = 'block';
            usernameInput.classList.add('is-invalid');
        } else {
            usernameError.textContent = '';
            usernameError.style.display = 'none';
            usernameInput.classList.remove('is-invalid');
        }
    });
});







// ========================================================================

document.addEventListener('DOMContentLoaded', function () {
    const addStaffForm = document.getElementById('add_staff_form');
    const staffNameInput = document.getElementById('full_name');
    const userGenderSelect = document.getElementById('gender');
    const userAgeInput = document.getElementById('age');
    const PhoneNoInput = document.getElementById('phone_no');
    const userAddressInput = document.getElementById('address');
    const usernameInput = document.getElementById('username');
    const userEmailInput = document.getElementById('email');
    const userPasswordInput = document.getElementById('password');

    // Function to validate password
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye_icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('ti-eye-off');
            eyeIcon.classList.add('ti-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('ti-eye');
            eyeIcon.classList.add('ti-eye-off');
        }
    }

    // Function to validate form
    function validateForm(event) {
        event.preventDefault(); // Prevent form submission

        let isValid = true;

        // Reset error messages and borders
        const errorSpans = document.querySelectorAll('.error');
        errorSpans.forEach(span => {
            span.textContent = '';
        });
        const inputFields = document.querySelectorAll('.form-control');
        inputFields.forEach(field => {
            field.classList.remove('is-invalid');
        });

        // Validate each input field
        if (!staffNameInput.value.trim()) {
            document.getElementById('full_name_error').textContent = 'Please enter your full name.';
            staffNameInput.classList.add('is-invalid');
            isValid = false;
        }

        if (userGenderSelect.value === '') {
            document.getElementById('gender_error').textContent = 'Please select gender.';
            userGenderSelect.classList.add('is-invalid');
            isValid = false;
        }

        if (!userAgeInput.value.trim()) {
            document.getElementById('age_error').textContent = 'Please enter your age.';
            userAgeInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!PhoneNoInput.value.trim()) {
            document.getElementById('phone_no_error').textContent = 'Please enter your phone number.';
            PhoneNoInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!userAddressInput.value.trim()) {
            document.getElementById('erorr_address').textContent = 'Please enter your address.';
            userAddressInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!usernameInput.value.trim()) {
            document.getElementById('username_err').textContent = 'Please enter your username.';
            usernameInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!userEmailInput.value.trim()) {
            document.getElementById('erorr_email').textContent = 'Please enter your email.';
            userEmailInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!userPasswordInput.value.trim()) {
            document.getElementById('erorr_password').textContent = 'Please enter your password.';
            userPasswordInput.classList.add('is-invalid');
            isValid = false;
        }

        if (isValid) {
            addStaffForm.submit(); // Submit the form if all inputs are valid
        }
    }

    // Event listeners
    addStaffForm.addEventListener('submit', validateForm);
    document.getElementById('toggle_password').addEventListener('click', togglePasswordVisibility);

    // Event listeners to remove error messages when typing in input fields
    staffNameInput.addEventListener('input', function () {
        document.getElementById('full_name_error').textContent = '';
        staffNameInput.classList.remove('is-invalid');
    });

    userGenderSelect.addEventListener('change', function () {
        document.getElementById('gender_error').textContent = '';
        userGenderSelect.classList.remove('is-invalid');
    });

    userAgeInput.addEventListener('input', function () {
        document.getElementById('age_error').textContent = '';
        userAgeInput.classList.remove('is-invalid');
    });

    PhoneNoInput.addEventListener('input', function () {
        document.getElementById('phone_no_error').textContent = '';
        PhoneNoInput.classList.remove('is-invalid');
    });

    userAddressInput.addEventListener('input', function () {
        document.getElementById('erorr_address').textContent = '';
        userAddressInput.classList.remove('is-invalid');
    });

    usernameInput.addEventListener('input', function () {
        document.getElementById('username_err').textContent = '';
        usernameInput.classList.remove('is-invalid');
    });

    userEmailInput.addEventListener('input', function () {
        document.getElementById('erorr_email').textContent = '';
        userEmailInput.classList.remove('is-invalid');
    });

    userPasswordInput.addEventListener('input', function () {
        document.getElementById('erorr_password').textContent = '';
        userPasswordInput.classList.remove('is-invalid');
    });
});
