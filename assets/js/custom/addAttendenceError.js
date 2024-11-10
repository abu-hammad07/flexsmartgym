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

    // Validate salary input
    const attendPhoneInput = document.getElementById('attend_phone');
    const attendPhoneError = document.getElementById('attend_phone_error');
    validateNumericInput(attendPhoneInput, attendPhoneError);
});




// ========================================================================

document.addEventListener('DOMContentLoaded', function () {
    const addAttendanceForm = document.getElementById('add_attendence_form');
    const attendNameInput = document.getElementById('attend_name');
    // const attendPhoneInput = document.getElementById('attend_phone');
    // const attendRoleInput = document.getElementById('attend_role');
    const attendDateInput = document.getElementById('attend_date');
    const attendStatusSelect = document.getElementById('attend_status');

    function validateForm(event) {
        event.preventDefault();

        let isValid = true;

        const errorSpans = document.querySelectorAll('.error');
        errorSpans.forEach(span => {
            span.textContent = '';
        });
        const inputFields = document.querySelectorAll('.form-control');
        inputFields.forEach(field => {
            field.classList.remove('is-invalid');
        });

        if (!attendNameInput.value.trim()) {
            document.getElementById('attend_name_error').textContent = 'Please select attendance username.';
            attendNameInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!attendDateInput.value.trim()) {
            document.getElementById('attend_date_error').textContent = 'Please enter attendance date.';
            attendDateInput.classList.add('is-invalid');
            isValid = false;
        }

        if (attendStatusSelect.value === '') {
            document.getElementById('attend_status_error').textContent = 'Please select status.';
            attendStatusSelect.classList.add('is-invalid');
            isValid = false;
        }

        if (isValid) {
            addAttendanceForm.submit();
        }
    }

    addAttendanceForm.addEventListener('submit', validateForm);

    attendNameInput.addEventListener('input', function () {
        document.getElementById('attend_name_error').textContent = '';
        attendNameInput.classList.remove('is-invalid');
    });


    attendDateInput.addEventListener('input', function () {
        document.getElementById('attend_date_error').textContent = '';
        attendDateInput.classList.remove('is-invalid');
    });

    attendStatusSelect.addEventListener('change', function () {
        document.getElementById('attend_status_error').textContent = '';
        attendStatusSelect.classList.remove('is-invalid');
    });
});
