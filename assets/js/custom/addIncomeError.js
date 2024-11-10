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
    const payFeesInput = document.getElementById('pay_fees');
    const payFeesError = document.getElementById('pay_fees_error');
    validateNumericInput(payFeesInput, payFeesError);

    // Validate age input
    const remainingFeesInput = document.getElementById('pay_remaining_fees');
    const remainingFeesError = document.getElementById('pay_remaining_fees_error');
    validateNumericInput(remainingFeesInput, remainingFeesError);

});










// ========================================================================

document.addEventListener('DOMContentLoaded', function () {
    const addIncomeForm = document.getElementById('add_income_form');
    const incomeNameSelect = document.getElementById('income_name');
    // const incomePhoneInput = document.getElementById('income_phone');
    // const subscriptionInput = document.getElementById('subscription');
    // const amountInput = document.getElementById('amount');
    // const feesDateInput = document.getElementById('fees_date');
    const monthlyDateInput = document.getElementById('monthly_date');
    const payFeesInput = document.getElementById('pay_fees');
    // const remainingFeesInput = document.getElementById('remaining_fees');

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
        if (!incomeNameSelect.value.trim()) {
            document.getElementById('income_name_error').textContent = 'Please Select Username.';
            incomeNameSelect.classList.add('is-invalid');
            isValid = false;
        }

        // if (!incomePhoneInput.value.trim()) {
        //     document.getElementById('income_phone_error').textContent = 'Please enter income phone number.';
        //     incomePhoneInput.classList.add('is-invalid');
        //     isValid = false;
        // }

        // if (subscriptionInput.value === '') {
        //     document.getElementById('subscription_error').textContent = 'Please select subscription.';
        //     subscriptionInput.classList.add('is-invalid');
        //     isValid = false;
        // }

        // if (amountInput.value === '') {
        //     document.getElementById('amount_error').textContent = 'Please select amount.';
        //     amountInput.classList.add('is-invalid');
        //     isValid = false;
        // }

        // if (!feesDateInput.value.trim()) {
        //     document.getElementById('fees_date_error').textContent = 'Please select fees date.';
        //     feesDateInput.classList.add('is-invalid');
        //     isValid = false;
        // }

        if (!monthlyDateInput.value.trim()) {
            document.getElementById('monthly_date_error').textContent = 'Please select monthly date.';
            monthlyDateInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!payFeesInput.value.trim()) {
            document.getElementById('pay_fees_error').textContent = 'Please enter pay fees.';
            payFeesInput.classList.add('is-invalid');
            isValid = false;
        }

        // if (!remainingFeesInput.value.trim()) {
        //     document.getElementById('remaining_fees_error').textContent = 'Please enter remaining fees.';
        //     remainingFeesInput.classList.add('is-invalid');
        //     isValid = false;
        // }

        if (isValid) {
            addIncomeForm.submit(); // Submit the form if all inputs are valid
        }
    }

    // Event listener
    addIncomeForm.addEventListener('submit', validateForm);

    // Add event listener to each input field
    const inputFields = document.querySelectorAll('.form-control');
    inputFields.forEach(field => {
        field.addEventListener('input', function () {
            const errorSpan = this.parentNode.querySelector('.error');
            errorSpan.textContent = '';
            this.classList.remove('is-invalid');
        });
    });
});
