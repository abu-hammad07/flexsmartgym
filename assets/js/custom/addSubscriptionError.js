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
    const subscripAmountInput = document.getElementById('membership_amount');
    const subscripAmountError = document.getElementById('membership_amount_error');
    validateNumericInput(subscripAmountInput, subscripAmountError);
});




// ========================================================================

document.addEventListener('DOMContentLoaded', function () {
    const addSubscripForm = document.getElementById('add_subscrip_form');
    const subscripNameInput = document.getElementById('membership_name');
    const subscripAmountInput = document.getElementById('membership_amount');
    const validationDaysInput = document.getElementById('validation_days');
    const membershipStatus = document.getElementById('membership_status');

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

        if (!subscripNameInput.value.trim()) {
            document.getElementById('membership_name_error').textContent = 'Please enter subscription name.';
            subscripNameInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!subscripAmountInput.value.trim()) {
            document.getElementById('membership_amount_error').textContent = 'Please enter subscription amount.';
            subscripAmountInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!validationDaysInput.value.trim()) {
            document.getElementById('validation_days_error').textContent = 'Please enter validation days.';
            validationDaysInput.classList.add('is-invalid');
            isValid = false;
        }

        if(!membershipStatus.value.trim()) {
            document.getElementById('membership_status_error').textContent = 'Please select membership status.';
            membershipStatus.classList.add('is-invalid');
            isValid = false;
        }

        if (isValid) {
            addSubscripForm.submit();
        }
    }

    addSubscripForm.addEventListener('submit', validateForm);

    subscripNameInput.addEventListener('input', function () {
        document.getElementById('membership_name_error').textContent = '';
        subscripNameInput.classList.remove('is-invalid');
    });

    subscripAmountInput.addEventListener('input', function () {
        document.getElementById('membership_amount_error').textContent = '';
        subscripAmountInput.classList.remove('is-invalid');
    });

    validationDaysInput.addEventListener('input', function () {
        document.getElementById('validation_days_error').textContent = '';
        validationDaysInput.classList.remove('is-invalid');
    });

    membershipStatus.addEventListener('input', function () {
        document.getElementById('membership_status_error').textContent = '';
        membershipStatus.classList.remove('is-invalid');
    });
});