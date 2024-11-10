// ======================== Add Futures Validation Code ========================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add_fetures_form');
    const futuresInput = document.getElementById('fetures');
    const futuresError = document.getElementById('fetures_error');

    function validateInputs() {
        let valid = true;
        // Validate Futures Name 
        if (futuresInput.value.trim() === '') {
            futuresError.textContent = 'Please fill in the futures.';
            futuresError.style.display = 'block';
            futuresInput.classList.add('is-invalid');
            valid = false;
        } else {
            futuresError.textContent = '';
            futuresError.style.display = 'none';
            futuresInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    futuresInput.addEventListener('input', validateInputs);
});