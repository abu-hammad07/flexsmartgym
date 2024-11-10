// ======================== Add category VAlidition code page (category)[category_save]  ========================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add_category_form');
    const categoryInput = document.getElementById('category');

    const categoryError = document.getElementById('category_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (categoryInput.value.trim() === '') {
            categoryError.textContent = 'Please fill in the category.';
            categoryError.style.display = 'block';
            categoryInput.classList.add('is-invalid');
            valid = false;
        } else {
            categoryError.textContent = '';
            categoryError.style.display = 'none';
            categoryInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    categoryInput.addEventListener('input', validateInputs);
});