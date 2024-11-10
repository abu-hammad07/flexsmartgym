// ====================== number only admission fees ======================
document.addEventListener('DOMContentLoaded', function () {
    // const addMemberForm = document.getElementById('add_member_form');
    const admissionFeesInput = document.getElementById('admission_fees');
    const admissionFeesError = document.getElementById('erorr_admission_fees');

    admissionFeesInput.addEventListener('input', function () {
        const inputValue = admissionFeesInput.value.trim();

        // Remove non-numeric characters
        const numericValue = inputValue.replace(/\D/g, '');

        // Check if input value is empty
        if (numericValue === '') {
            admissionFeesError.textContent = '';
            admissionFeesError.style.display = 'block';
            admissionFeesInput.classList.add('is-invalid');
        }
        // Update the input value with the cleaned numeric value
        admissionFeesInput.value = numericValue;
    });
});
// ====================== number only age ======================
document.addEventListener('DOMContentLoaded', function () {
    // const addMemberForm = document.getElementById('add_member_form');
    const ageInput = document.getElementById('age');
    const ageError = document.getElementById('age_error');

    ageInput.addEventListener('input', function () {
        const inputValue = ageInput.value.trim();

        // Remove non-numeric characters
        const numericValue = inputValue.replace(/\D/g, '');

        // Check if input value is empty
        if (numericValue === '') {
            ageError.textContent = '';
            ageError.style.display = 'block';
            ageInput.classList.add('is-invalid');
        }
        // Update the input value with the cleaned numeric value
        ageInput.value = numericValue;
    });
});

// ====================== number only ======================
document.addEventListener('DOMContentLoaded', function () {
    // const addMemberForm = document.getElementById('add_member_form');
    const monthlyFeesInput = document.getElementById('monthly_fees');
    const monthlyFeesError = document.getElementById('erorr_monthly_fees');

    monthlyFeesInput.addEventListener('input', function () {
        const inputValue = monthlyFeesInput.value.trim();

        // Remove non-numeric characters
        const numericValue = inputValue.replace(/\D/g, '');

        // Check if input value is empty
        if (numericValue === '') {
            monthlyFeesError.textContent = '';
            monthlyFeesError.style.display = 'block';
            monthlyFeesInput.classList.add('is-invalid');
        }
        // Update the input value with the cleaned numeric value
        monthlyFeesInput.value = numericValue;
    });
});

// ====================== number only ======================
document.addEventListener('DOMContentLoaded', function () {
    // const addMemberForm = document.getElementById('add_member_form');
    const phoneNoInput = document.getElementById('phone_no');
    const phoneNoError = document.getElementById('phone_no_error');

    phoneNoInput.addEventListener('input', function (event) {
        let inputValue = phoneNoInput.value.trim();
        let numericValue = '';

        // Remove non-numeric characters and ensure only digits
        for (let i = 0; i < inputValue.length; i++) {
            if (!isNaN(inputValue[i])) {
                numericValue += inputValue[i];
            }
        }

        // Update the input value with the cleaned numeric value
        phoneNoInput.value = numericValue;

        // Check if numericValue is empty or not exactly 11 digits long
        if (numericValue === '' || numericValue.length !== 11) {
            phoneNoError.textContent = '';
            phoneNoError.style.display = 'block';
            phoneNoInput.classList.add('is-invalid');
        } else {
            phoneNoError.textContent = '';
            phoneNoError.style.display = 'none';
            phoneNoInput.classList.remove('is-invalid');
        }
    });
});




// ======================= password show hide &  manimum 8 character ======================
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const passwordError = document.getElementById('erorr_password');
    const togglePasswordButton = document.getElementById('toggle_password');
    const eyeIcon = document.getElementById('eye_icon');

    togglePasswordButton.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        // Change the icon based on password visibility
        eyeIcon.className = type === 'password' ? 'ti ti-eye-off' : 'ti ti-eye';
    });

    passwordInput.addEventListener('input', function () {
        const inputValue = passwordInput.value.trim();

        // Check if input value is empty
        if (inputValue === '') {
            passwordError.textContent = '';
            passwordError.style.display = 'block';
            passwordInput.classList.add('is-invalid');
        }
        // Check if input value exceeds 8 characters
        else if (inputValue.length < 8) {
            passwordError.textContent = 'Password should be at least 8 characters long.';
            passwordError.style.display = 'block';
            passwordInput.classList.add('is-invalid');
        } else {
            passwordError.textContent = '';
            passwordError.style.display = 'none';
            passwordInput.classList.remove('is-invalid');
        }
    });
});

// ======================== username lowercase only  ======================
document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('username');
    const usernameError = document.getElementById('error_username');

    usernameInput.addEventListener('input', function () {
        let inputValue = usernameInput.value.trim();

        // Convert input value to lowercase
        inputValue = inputValue.toLowerCase();
        usernameInput.value = inputValue;

        // Check if input value is empty
        if (inputValue === '') {
            usernameError.textContent = 'Username cannot be empty.';
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







