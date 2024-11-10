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










// ========================================================================

document.addEventListener('DOMContentLoaded', function () {
    const addIncomeForm = document.getElementById('add_salary_form');
    const incomeNameInput = document.getElementById('salary_name');
    const payFeesInput = document.getElementById('pay_salary');
    const monthlyDateInput = document.getElementById('monthly_date');

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
        if (!incomeNameInput.value.trim()) {
            document.getElementById('salary_name_error').textContent = 'Please Select Username.';
            incomeNameInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!payFeesInput.value.trim()) {
            document.getElementById('pay_salary_error').textContent = 'Please enter pay salary.';
            payFeesInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!monthlyDateInput.value.trim()) {
            document.getElementById('monthly_date_error').textContent = 'Please select monthly date.';
            monthlyDateInput.classList.add('is-invalid');
            isValid = false;
        }


        if (isValid) {
            addIncomeForm.submit(); // Submit the form if all inputs are valid
        }
    }

    // Event listener
    addIncomeForm.addEventListener('submit', validateForm);

    // Event listeners to remove error messages when typing in input fields
    incomeNameInput.addEventListener('input', function () {
        document.getElementById('salary_name_error').textContent = '';
        incomeNameInput.classList.remove('is-invalid');
    });

    payFeesInput.addEventListener('input', function () {
        document.getElementById('pay_salary_error').textContent = '';
        payFeesInput.classList.remove('is-invalid');
    });

    monthlyDateInput.addEventListener('input', function () {
        document.getElementById('monthly_date_error').textContent = '';
        monthlyDateInput.classList.remove('is-invalid');
    });


});
