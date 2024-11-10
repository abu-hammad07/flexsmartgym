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
    const expenseAmountInput = document.getElementById('expense_amount');
    const expenseAmountError = document.getElementById('expense_amount_error');
    validateNumericInput(expenseAmountInput, expenseAmountError);
});




// ========================================================================
document.addEventListener('DOMContentLoaded', function () {
    const addExpenseForm = document.getElementById('add_expense_form');
    const expenseNameInput = document.getElementById('expense_name');
    const expenseCategorySelect = document.getElementById('expense_category');
    const expenseAmountInput = document.getElementById('expense_amount');
    const expenseImageInput = document.getElementById('expense_image');

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

        if (!expenseNameInput.value.trim()) {
            document.getElementById('expense_name_error').textContent = 'Please enter expense name.';
            expenseNameInput.classList.add('is-invalid');
            isValid = false;
        }

        if (expenseCategorySelect.value === '') {
            document.getElementById('expense_category_error').textContent = 'Please select expense category.';
            expenseCategorySelect.classList.add('is-invalid');
            isValid = false;
        }

        if (!expenseAmountInput.value.trim()) {
            document.getElementById('expense_amount_error').textContent = 'Please enter expense amount.';
            expenseAmountInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!expenseImageInput.value.trim()) {
            document.getElementById('expense_image_error').textContent = 'Please select an expense image.';
            expenseImageInput.classList.add('is-invalid');
            isValid = false;
        }

        if (isValid) {
            addExpenseForm.submit();
        }
    }

    addExpenseForm.addEventListener('submit', validateForm);

    expenseNameInput.addEventListener('input', function () {
        document.getElementById('expense_name_error').textContent = '';
        expenseNameInput.classList.remove('is-invalid');
    });

    expenseCategorySelect.addEventListener('change', function () {
        document.getElementById('expense_category_error').textContent = '';
        expenseCategorySelect.classList.remove('is-invalid');
    });

    expenseAmountInput.addEventListener('input', function () {
        document.getElementById('expense_amount_error').textContent = '';
        expenseAmountInput.classList.remove('is-invalid');
    });

    expenseImageInput.addEventListener('change', function () {
        document.getElementById('expense_image_error').textContent = '';
        expenseImageInput.classList.remove('is-invalid');
    });
});
