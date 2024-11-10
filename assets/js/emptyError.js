// // ====================== number only ======================
// document.addEventListener('DOMContentLoaded', function () {
//     const phoneNoInput = document.getElementById('phone_no');
//     const phoneNoError = document.getElementById('phone_no_error');

//     phoneNoInput.addEventListener('input', function () {
//         const inputValue = phoneNoInput.value.trim();

//         // Remove non-numeric characters
//         const numericValue = inputValue.replace(/\D/g, '');

//         // Check if input value is empty
//         if (numericValue === '') {
//             phoneNoError.textContent = 'Phone number only.';
//             phoneNoError.style.display = 'block';
//             phoneNoInput.classList.add('is-invalid');
//         }
//         // Check if the numeric value exceeds 11 digits
//         else if (numericValue.length > 11) {
//             phoneNoError.textContent = 'Phone number should not exceed 11 digits.';
//             phoneNoError.style.display = 'block';
//             phoneNoInput.classList.add('is-invalid');
//         } else {
//             phoneNoError.textContent = '';
//             phoneNoError.style.display = 'none';
//             phoneNoInput.classList.remove('is-invalid');
//         }

//         // Update the input value with the cleaned numeric value
//         phoneNoInput.value = numericValue;
//     });
// });

// // ======================== username lowercase only  ======================
// document.addEventListener('DOMContentLoaded', function () {
//     const usernameInput = document.getElementById('username');
//     const usernameError = document.getElementById('username_error');

//     usernameInput.addEventListener('input', function () {
//         const inputValue = usernameInput.value.trim();

//         // Check if input value is empty
//         if (inputValue === '') {
//             usernameError.textContent = 'Username cannot be empty.';
//             usernameError.style.display = 'block';
//             usernameInput.classList.add('is-invalid');
//         }
//         // Check if input value contains uppercase letters
//         else if (inputValue.toLowerCase() !== inputValue) {
//             usernameError.textContent = 'Username should be in lowercase.';
//             usernameError.style.display = 'block';
//             usernameInput.classList.add('is-invalid');
//         } else {
//             usernameError.textContent = '';
//             usernameError.style.display = 'none';
//             usernameInput.classList.remove('is-invalid');
//         }
//     });
// });

// // ======================= password show hide &  manimum 8 character ======================
// document.addEventListener('DOMContentLoaded', function () {
//     const passwordInput = document.getElementById('password');
//     const passwordError = document.getElementById('password_error');
//     const togglePasswordButton = document.getElementById('toggle_password');
// const eyeIcon = document.getElementById('eye_icon');

// togglePasswordButton.addEventListener('click', function () {
//     const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
//     passwordInput.setAttribute('type', type);
//     // Change the icon based on password visibility
//     eyeIcon.className = type === 'password' ? 'ti ti-eye-off' : 'ti ti-eye';
// });

// passwordInput.addEventListener('input', function () {
//     const inputValue = passwordInput.value.trim();

//         // Check if input value is empty
//         if (inputValue === '') {
//             passwordError.textContent = 'Password cannot be empty.';
//             passwordError.style.display = 'block';
//             passwordInput.classList.add('is-invalid');
//         }
//         // Check if input value exceeds 8 characters
//         else if (inputValue.length < 8) {
//             passwordError.textContent = 'Password should be at least 8 characters long.';
//             passwordError.style.display = 'block';
//             passwordInput.classList.add('is-invalid');
//         } else {
//             passwordError.textContent = '';
//             passwordError.style.display = 'none';
//             passwordInput.classList.remove('is-invalid');
//         }
//     });
// });

// // ================================= email validation ================================
// document.addEventListener('DOMContentLoaded', function () {
//     const emailInput = document.getElementById('email');
//     const emailError = document.getElementById('email_error');

//     emailInput.addEventListener('input', function () {
//         const inputValue = emailInput.value.trim();
//         // Regular expression for email validation
//         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//         if (inputValue === '') {
//             emailError.textContent = 'Email cannot be empty.';
//             emailError.style.display = 'block';
//             emailInput.classList.add('is-invalid');
//         } else if (!emailRegex.test(inputValue)) {
//             emailError.textContent = 'Please enter a valid email address.';
//             emailError.style.display = 'block';
//             emailInput.classList.add('is-invalid');
//         } else {
//             emailError.textContent = '';
//             emailError.style.display = 'none';
//             emailInput.classList.remove('is-invalid');
//         }
//     });
// });

// // ================================== age only number validation ================================
// document.addEventListener('DOMContentLoaded', function () {
//     const ageInput = document.getElementById('age');
//     const ageError = document.getElementById('age_error');

//     ageInput.addEventListener('input', function () {
//         const inputValue = ageInput.value.trim();

//         // Remove non-numeric characters
//         const numericValue = inputValue.replace(/\D/g, '');

//         // Check if input value is empty
//         if (numericValue === '') {
//             ageError.textContent = 'Age number only .';
//             ageError.style.display = 'block';
//             ageInput.classList.add('is-invalid');
//         } else {
//             ageError.textContent = '';
//             ageError.style.display = 'none';
//             ageInput.classList.remove('is-invalid');
//         }

//         // Update the input value with the cleaned numeric value
//         ageInput.value = numericValue;
//     });
// });

// // ================================== Form Validation ================================
// document.addEventListener('DOMContentLoaded', function () {
//     const form = document.getElementById('myForm');
//     const fNameInput = document.getElementById('f_name');
//     const lNameInput = document.getElementById('l_name');
//     const addressInput = document.getElementById('address');
//     const genderSelect = document.getElementById('gender');
//     // const ageInput = document.getElementById('age');
//     // const emailInput = document.getElementById('email');
//     // const passwordInput = document.getElementById('password');
//     const fNameError = document.getElementById('f_name_error');
//     const lNameError = document.getElementById('l_name_error');
//     const addressError = document.getElementById('address_error');
//     const genderError = document.getElementById('gender_error');
//     const ageError = document.getElementById('age_error');

//     function validateInputs() {
//         let valid = true;
//         // Validate first name
//         if (fNameInput.value.trim() === '') {
//             fNameError.textContent = 'Please fill in the first name.';
//             fNameError.style.display = 'block';
//             fNameInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             fNameError.textContent = '';
//             fNameError.style.display = 'none';
//             fNameInput.classList.remove('is-invalid');
//         }
//         // Validate last name
//         if (lNameInput.value.trim() === '') {
//             lNameError.textContent = 'Please fill in the last name.';
//             lNameError.style.display = 'block';
//             lNameInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             lNameError.textContent = '';
//             lNameError.style.display = 'none';
//             lNameInput.classList.remove('is-invalid');
//         }
//         // Validate address
//         if (addressInput.value.trim() === '') {
//             addressError.textContent = 'Please fill in the address.';
//             addressError.style.display = 'block';
//             addressInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             addressError.textContent = '';
//             addressError.style.display = 'none';
//             addressInput.classList.remove('is-invalid');
//         }
//         // Validate gender
//         if (genderSelect.value === '') {
//             genderError.textContent = 'Please select a gender.';
//             genderError.style.display = 'block';
//             genderSelect.classList.add('is-invalid');
//             valid = false;
//         } else {
//             genderError.textContent = '';
//             genderError.style.display = 'none';
//             genderSelect.classList.remove('is-invalid');
//         }

//         return valid;
//     }

//     form.addEventListener('submit', function (event) {
//         if (!validateInputs()) {
//             event.preventDefault(); // Prevent form submission if validation fails
//         }
//     });

//     fNameInput.addEventListener('input', validateInputs);
//     lNameInput.addEventListener('input', validateInputs);
//     lNameInput.addEventListener('input', validateInputs);
//     addressInput.addEventListener('input', validateInputs);
//     genderSelect.addEventListener('input', validateInputs);
// });





// ========================= validition for all fields add admin page (admin-details)  =========================

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('adminForm');
    const inputs = {
        'f_name': document.getElementById('f_name'),
        'l_name': document.getElementById('l_name'),
        'address': document.getElementById('address'),
        'gender': document.getElementById('gender'),
        'age': document.getElementById('age'),
        'email': document.getElementById('email'),
        'phone_no': document.getElementById('phone_no'),
        'username': document.getElementById('username'),
        'password': document.getElementById('password')
    };

    const errors = {
        'f_name': document.getElementById('f_name_error'),
        'l_name': document.getElementById('l_name_error'),
        'address': document.getElementById('address_error'),
        'gender': document.getElementById('gender_error'),
        'age': document.getElementById('age_error'),
        'email': document.getElementById('email_error'),
        'phone_no': document.getElementById('phone_no_error'),
        'username': document.getElementById('username_error'),
        'password': document.getElementById('password_error')
    };

    const capitalizeFirstLetter = function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    };

    function validateInputs() {
        let valid = true;
        let emptyField = false;

        for (const key in inputs) {
            const input = inputs[key];
            const error = errors[key];
            let inputValue = input.value.trim();

            if (key === 'age' || key === 'phone_no') {
                inputValue = inputValue.replace(/\D/g, ''); // Remove non-numeric characters
                input.value = inputValue; // Update input value with cleaned numeric value
            }

            if (inputValue === '') {
                error.textContent = 'This field cannot be empty.';
                error.style.display = 'block';
                input.classList.add('is-invalid');
                emptyField = true;
            } else {
                error.textContent = '';
                error.style.display = 'none';
                input.classList.remove('is-invalid');
            }

            if (key === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(inputValue)) {
                    error.textContent = 'Please enter a valid email address.';
                    error.style.display = 'block';
                    input.classList.add('is-invalid');
                    valid = false;
                }
            }

            if (key === 'username') {
                if (inputValue.toLowerCase() !== inputValue) {
                    error.textContent = 'Username should be in lowercase.';
                    error.style.display = 'block';
                    input.classList.add('is-invalid');
                    valid = false;
                }
            }

            if (key === 'password') {
                if (inputValue.length < 8) {
                    error.textContent = 'Password should be at least 8 characters long.';
                    error.style.display = 'block';
                    input.classList.add('is-invalid');
                    valid = false;
                }
            }

            if (key === 'phone_no') {
                if (inputValue.length > 11) {
                    error.textContent = 'Phone number should not exceed 11 digits.';
                    error.style.display = 'block';
                    // input.classList.add('is-invalid');
                    valid = false;
                }
            }

            if (key === 'age') {
                if (isNaN(inputValue)) { // Check if value is not a number
                    error.textContent = 'Please enter a valid age.';
                    error.style.display = 'block';
                    input.classList.add('is-invalid');
                    valid = false;
                }
            }
        }

        if (emptyField && valid) {
            valid = false;
        }

        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    for (const key in inputs) {
        inputs[key].addEventListener('input', validateInputs);
    }

    // Capitalize first letter of first name and last name
    inputs['f_name'].addEventListener('input', function () {
        const inputValue = inputs['f_name'].value.trim();
        inputs['f_name'].value = capitalizeFirstLetter(inputValue);
    });

    inputs['l_name'].addEventListener('input', function () {
        const inputValue = inputs['l_name'].value.trim();
        inputs['l_name'].value = capitalizeFirstLetter(inputValue);
    });

    // Eye icon toggle functionality
    const togglePasswordButton = document.getElementById('toggle_password');
    const eyeIcon = document.getElementById('eye_icon');
    const passwordInput = inputs['password'];

    togglePasswordButton.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        // Change the icon based on password visibility
        eyeIcon.className = type === 'password' ? 'ti ti-eye-off' : 'ti ti-eye';
    });
});



// =================== Compose Message VAlidition page (compose-message) ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('messageForm');
    const toIdInput = document.getElementById('select2Basic');
    const msgStatusInput = document.getElementById('msg_status');
    const msgSubjectInput = document.getElementById('msg_subject');

    const toIdError = document.getElementById('to_id_error');
    const statusError = document.getElementById('status_error');
    const subjectError = document.getElementById('subject_error');

    function validateInputs() {
        let valid = true;
        // Validate users
        if (toIdInput.selectedIndex === 0) {
            toIdError.textContent = 'Please select the user.';
            toIdError.style.display = 'block';
            toIdInput.classList.add('is-invalid');
            valid = false;
        } else {
            toIdError.textContent = '';
            toIdError.style.display = 'none';
            toIdInput.classList.remove('is-invalid');
        }
        // Validate Status
        if (msgStatusInput.selectedIndex === 0) {
            statusError.textContent = 'Please select the status.';
            statusError.style.display = 'block';
            msgStatusInput.classList.add('is-invalid');
            valid = false;
        } else {
            statusError.textContent = '';
            statusError.style.display = 'none';
            msgStatusInput.classList.remove('is-invalid');
        }
        // Validate Subject 
        if (msgSubjectInput.value.trim() === '') {
            subjectError.textContent = 'Please fill in the subject.';
            subjectError.style.display = 'block';
            msgSubjectInput.classList.add('is-invalid');
            valid = false;
        } else {
            subjectError.textContent = '';
            subjectError.style.display = 'none';
            msgSubjectInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    toIdInput.addEventListener('input', validateInputs);
    msgStatusInput.addEventListener('input', validateInputs);
    msgSubjectInput.addEventListener('input', validateInputs);
});



// =================== Interested VAlidition page (interested-source)[interested] ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('interestForm');
    const interestNameInput = document.getElementById('interes_name');

    const interest_nameError = document.getElementById('interes_name_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (interestNameInput.value.trim() === '') {
            interest_nameError.textContent = 'Please fill in the interested.';
            interest_nameError.style.display = 'block';
            interestNameInput.classList.add('is-invalid');
            valid = false;
        } else {
            interest_nameError.textContent = '';
            interest_nameError.style.display = 'none';
            interestNameInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    interestNameInput.addEventListener('input', validateInputs);
});

// =================== Source VAlidition page (interested-source)[source] ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('sourceForm');
    const sourceameInput = document.getElementById('source_name');

    const source_meError = document.getElementById('source_name_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (sourceameInput.value.trim() === '') {
            source_meError.textContent = 'Please fill in the source.';
            source_meError.style.display = 'block';
            sourceameInput.classList.add('is-invalid');
            valid = false;
        } else {
            source_meError.textContent = '';
            source_meError.style.display = 'none';
            sourceameInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    sourceameInput.addEventListener('input', validateInputs);
});

// =================== Source VAlidition page (assignROle-specialize)[assign-role] ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('assignForm');
    const assignInput = document.getElementById('assign_name');

    const assignNameError = document.getElementById('assign_name_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (assignInput.value.trim() === '') {
            assignNameError.textContent = 'Please fill in the assign role.';
            assignNameError.style.display = 'block';
            assignInput.classList.add('is-invalid');
            valid = false;
        } else {
            assignNameError.textContent = '';
            assignNameError.style.display = 'none';
            assignInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    assignInput.addEventListener('input', validateInputs);
});


// =================== Source VAlidition page (assignROle-specialize)[assign-role] ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('specializeForm');
    const specialInput = document.getElementById('special_name');

    const specialNameError = document.getElementById('special_name_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (specialInput.value.trim() === '') {
            specialNameError.textContent = 'Please fill in the assign role.';
            specialNameError.style.display = 'block';
            specialInput.classList.add('is-invalid');
            valid = false;
        } else {
            specialNameError.textContent = '';
            specialNameError.style.display = 'none';
            specialInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    specialInput.addEventListener('input', validateInputs);
});



// =================== Source VAlidition page (category-installment)[category] ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('categoryForm');
    const categoryInput = document.getElementById('category_name');

    const categoryNameError = document.getElementById('category_name_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (categoryInput.value.trim() === '') {
            categoryNameError.textContent = 'Please fill in the category.';
            categoryNameError.style.display = 'block';
            categoryInput.classList.add('is-invalid');
            valid = false;
        } else {
            categoryNameError.textContent = '';
            categoryNameError.style.display = 'none';
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


// =================== Source VAlidition page (category-installment)[installment] ======================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('install_form');
    const installInput = document.getElementById('install_name');

    const installNameError = document.getElementById('install_name_error');

    function validateInputs() {
        let valid = true;
        // Validate Subject 
        if (installInput.value.trim() === '') {
            installNameError.textContent = 'Please fill in the installment.';
            installNameError.style.display = 'block';
            installInput.classList.add('is-invalid');
            valid = false;
        } else {
            installNameError.textContent = '';
            installNameError.style.display = 'none';
            installInput.classList.remove('is-invalid');
        }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    installInput.addEventListener('input', validateInputs);
});




// =================== membership VAlidition page (membership) ======================
// document.addEventListener('DOMContentLoaded', function () {
//     const form = document.getElementById('membershipForm');

//     const shipNameInput = document.getElementById('ship_name');
//     const shipCategorySelect = document.getElementById('ship_category');
//     const shipPeriodInput = document.getElementById('ship_period');
//     const shipClassSelect = document.getElementById('ship_class_slt');
//     const shipAmountInput = document.getElementById('ship_amount');
//     const shipSignupFeeInput = document.getElementById('ship_signup_fee');
//     const shipInstallAmount = document.getElementById('ship_install_amount');

//     const shipNameError = document.getElementById('ship_name_error');
//     const shipCategoryError = document.getElementById('ship_category_error');
//     const shipPeriodError = document.getElementById('ship_period_error');
//     const shipClassSltError = document.getElementById('ship_class_slt_error');
//     const shipAmountError = document.getElementById('ship_amount_error');
//     const shipSignupFeeError = document.getElementById('ship_signup_fee_error');
//     const shipInstallAmountError = document.getElementById('ship_install_amount_error');

//     function validateInputs() {
//         let valid = true;
//         // Validate membership name
//         if (shipNameInput.value.trim() === '') {
//             shipNameError.textContent = 'Please fill in the name.';
//             shipNameError.style.display = 'block';
//             shipNameInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipNameError.textContent = '';
//             shipNameError.style.display = 'none';
//             shipNameInput.classList.remove('is-invalid');
//         }
//         // Validate membership Category
//         if (shipCategorySelect.selectedIndex === 0) {
//             shipCategoryError.textContent = 'Please select the category.';
//             shipCategoryError.style.display = 'block';
//             shipCategorySelect.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipCategoryError.textContent = '';
//             shipCategoryError.style.display = 'none';
//             shipCategorySelect.classList.remove('is-invalid');
//         }
//         // Validate membership Limit
//         if (shipPeriodInput.value.trim() === '') {
//             shipPeriodError.textContent = 'Please select the limit.';
//             shipPeriodError.style.display = 'block';
//             shipPeriodInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipPeriodError.textContent = '';
//             shipPeriodError.style.display = 'none';
//             shipPeriodInput.classList.remove('is-invalid');
//         }
//         // Validate membership Amount
//         if ((/^\d*\.?\d*$/.test(shipAmountInput.value.trim()))) {
//             shipAmountError.textContent = 'Please enter a number only.';
//             shipAmountError.style.display = 'block';
//             shipAmountInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipAmountError.textContent = '';
//             shipAmountError.style.display = 'none';
//             shipAmountInput.classList.remove('is-invalid');
//         }
//         // Validate membership Class
//         if (shipClassSelect.value.trim() === '') {
//             shipClassSltError.textContent = 'Please select a class.'; // Updated error message
//             shipClassSltError.style.display = 'block';
//             shipClassSelect.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipClassSltError.textContent = '';
//             shipClassSltError.style.display = 'none';
//             shipClassSelect.classList.remove('is-invalid');
//         }
//         // Validate membership Signup Fee
//         if (!(/^\d+(\.\d{1,2})?$/.test(shipSignupFeeInput.value.trim()))) {
//             shipSignupFeeError.textContent = 'Please enter a number only.';
//             shipSignupFeeError.style.display = 'block';
//             shipSignupFeeInput.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipSignupFeeError.textContent = '';
//             shipSignupFeeError.style.display = 'none';
//             shipSignupFeeInput.classList.remove('is-invalid');
//         }
//         // Validate membership Install Amount
//         if (!(/^\d+(\.\d{1,2})?$/.test(shipInstallAmount.value.trim()))) {
//             shipInstallAmountError.textContent = 'Please enter a number only.';
//             shipInstallAmountError.style.display = 'block';
//             shipInstallAmount.classList.add('is-invalid');
//             valid = false;
//         } else {
//             shipInstallAmountError.textContent = '';
//             shipInstallAmountError.style.display = 'none';
//             shipInstallAmount.classList.remove('is-invalid');
//         }
//         return valid;
//     }

//     form.addEventListener('submit', function (event) {
//         if (!validateInputs()) {
//             event.preventDefault(); // Prevent form submission if validation fails
//         }
//     });

//     shipNameInput.addEventListener('input', validateInputs);
//     shipCategorySelect.addEventListener('input', validateInputs);
//     shipPeriodInput.addEventListener('input', validateInputs);
//     shipLimitSelect.addEventListener('input', validateInputs);
//     shipAmountInput.addEventListener('input', validateInputs);
//     shipClassSelect.addEventListener('input', validateInputs);
//     shipSignupFeeInput.addEventListener('input', validateInputs);
//     shipInstallAmount.addEventListener('input', validateInputs);
// });

// =======================================================================================
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('membershipForm');

    const shipNameInput = document.getElementById('ship_name');
    const shipCategorySelect = document.getElementById('ship_category');
    const shipPeriodInput = document.getElementById('ship_period');
    const shipClassSelect = document.getElementById('ship_class_slt');
    const shipAmountInput = document.getElementById('ship_amount');
    const shipSignupFeeInput = document.getElementById('ship_signup_fee');
    const shipInstallAmount = document.getElementById('ship_install_amount');

    const shipNameError = document.getElementById('ship_name_error');
    const shipCategoryError = document.getElementById('ship_category_error');
    const shipPeriodError = document.getElementById('ship_period_error');
    const shipClassSltError = document.getElementById('ship_class_slt_error');
    const shipAmountError = document.getElementById('ship_amount_error');
    const shipSignupFeeError = document.getElementById('ship_signup_fee_error');
    const shipInstallAmountError = document.getElementById('ship_install_amount_error');

    function validateInputs() {
        let valid = true;
        // Validate membership name
        if (shipNameInput.value.trim() === '') {
            shipNameError.textContent = 'Please fill in the name.';
            shipNameError.style.display = 'block';
            shipNameInput.classList.add('is-invalid');
            valid = false;
        } else {
            shipNameError.textContent = '';
            shipNameError.style.display = 'none';
            shipNameInput.classList.remove('is-invalid');
        }
        // Validate membership Category
        if (shipCategorySelect.selectedIndex === 0) {
            shipCategoryError.textContent = 'Please select the category.';
            shipCategoryError.style.display = 'block';
            shipCategorySelect.classList.add('is-invalid');
            valid = false;
        } else {
            shipCategoryError.textContent = '';
            shipCategoryError.style.display = 'none';
            shipCategorySelect.classList.remove('is-invalid');
        }
        // Validate membership Limit
        if (shipPeriodInput.value.trim() === '') {
            shipPeriodError.textContent = 'Please select the limit.';
            shipPeriodError.style.display = 'block';
            shipPeriodInput.classList.add('is-invalid');
            valid = false;
        } else {
            shipPeriodError.textContent = '';
            shipPeriodError.style.display = 'none';
            shipPeriodInput.classList.remove('is-invalid');
        }
        // Validate membership Amount
        // if (!(/^\d*\.?\d*$/.test(shipAmountInput.value.trim()))) {
        //     shipAmountError.textContent = 'Please enter a number only.';
        //     shipAmountError.style.display = 'block';
        //     shipAmountInput.classList.add('is-invalid');
        //     valid = false;
        // } else {
        //     shipAmountError.textContent = '';
        //     shipAmountError.style.display = 'none';
        //     shipAmountInput.classList.remove('is-invalid');
        // }
        // Validate membership Class
        if (shipClassSelect.value.trim() === '') {
            shipClassSltError.textContent = 'Please select a class.'; // Updated error message
            shipClassSltError.style.display = 'block';
            shipClassSelect.classList.add('is-invalid');
            valid = false;
        } else {
            shipClassSltError.textContent = '';
            shipClassSltError.style.display = 'none';
            shipClassSelect.classList.remove('is-invalid');
        }
        // // Validate membership Signup Fee
        // if (!(/^\d*\.?\d*$/.test(shipSignupFeeInput.value.trim()))) {
        //     shipSignupFeeError.textContent = 'Please enter a number only.';
        //     shipSignupFeeError.style.display = 'block';
        //     shipSignupFeeInput.classList.add('is-invalid');
        //     valid = false;
        // } else {
        //     shipSignupFeeError.textContent = '';
        //     shipSignupFeeError.style.display = 'none';
        //     shipSignupFeeInput.classList.remove('is-invalid');
        // }
        // // Validate membership Install Amount
        // if (!(/^\d*\.?\d*$/.test(shipInstallAmount.value.trim()))) {
        //     shipInstallAmountError.textContent = 'Please enter a number only.';
        //     shipInstallAmountError.style.display = 'block';
        //     shipInstallAmount.classList.add('is-invalid');
        //     valid = false;
        // } else {
        //     shipInstallAmountError.textContent = '';
        //     shipInstallAmountError.style.display = 'none';
        //     shipInstallAmount.classList.remove('is-invalid');
        // }
        return valid;
    }

    form.addEventListener('submit', function (event) {
        if (!validateInputs()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    shipNameInput.addEventListener('input', validateInputs);
    shipCategorySelect.addEventListener('input', validateInputs);
    shipPeriodInput.addEventListener('input', validateInputs);
    shipClassSelect.addEventListener('input', validateInputs);

    shipAmountInput.addEventListener('input', function () {
        if (!(/^\d*\.?\d*$/.test(shipAmountInput.value.trim()))) {
            shipAmountInput.value = shipAmountInput.value.slice(0, -1);
        }
        validateInputs();
    });
    shipSignupFeeInput.addEventListener('input', function () {
        if (!(/^\d*\.?\d*$/.test(shipSignupFeeInput.value.trim()))) {
            shipSignupFeeInput.value = shipSignupFeeInput.value.slice(0, -1);
        }
        validateInputs();
    });
    shipInstallAmount.addEventListener('input', function () {
        if (!(/^\d*\.?\d*$/.test(shipInstallAmount.value.trim()))) {
            shipInstallAmount.value = shipInstallAmount.value.slice(0, -1);
        }
        validateInputs();
    });
});




// document.addEventListener('DOMContentLoaded', function () {
//     const formMembership = document.getElementById('membershipForm');
//     const shipInputs = {
//         'shipName': document.getElementById('ship_name'),
//         'shipCategory': document.getElementById('ship_category'),
//         'shipPeriod': document.getElementById('ship_period'),
//         'shipAmount': document.getElementById('ship_amount'),
//         'shipClass': document.getElementById('ship_class_slt'),
//         'shipSignupFee': document.getElementById('ship_signup_fee'),
//         'shipInstallAmount': document.getElementById('ship_install_amount'),
//         // 'username': document.getElementById('username'),
//         // 'password': document.getElementById('password')
//     };

//     const shipErrors = {
//         'shipNameError': document.getElementById('ship_name_error'),
//         'shipCategoryError': document.getElementById('ship_category_error'),
//         'shipPeriodError': document.getElementById('ship_period_error'),
//         'shipAmountError': document.getElementById('ship_amount_error'),
//         'shipClassError': document.getElementById('ship_class_slt_error'),
//         'shipSignupFeeError': document.getElementById('ship_signup_fee_error'),
//         'shipInstallAmountError': document.getElementById('ship_install_amount_error'),
//         // 'username': document.getElementById('username_error'),
//         // 'password': document.getElementById('password_error')
//     };

//     const capitalizeFirstLetter = function (str) {
//         return str.charAt(0).toUpperCase() + str.slice(1);
//     };

//     function validateInputs() {
//         let valid = true;
//         let emptyField = false;

//         for (const key in shipInputs) {
//             const input = shipInputs[key];
//             const error = shipErrors[key];
//             let inputValue = input.value.trim();

//             if (key === 'shipAmount' || key === 'shipSignupFee' || key === 'shipInstallAmount') {
//                 inputValue = inputValue.replace(/\D/g, ''); // Remove non-numeric characters
//                 input.value = inputValue; // Update input value with cleaned numeric value
//             }

//             if (inputValue === '') {
//                 error.textContent = 'This field cannot be empty.';
//                 error.style.display = 'block';
//                 input.classList.add('is-invalid');
//                 emptyField = true;
//             } else {
//                 error.textContent = '';
//                 error.style.display = 'none';
//                 input.classList.remove('is-invalid');
//             }
//         }

//         if (emptyField && valid) {
//             valid = false;
//         }

//         return valid;
//     }

//     formMembership.addEventListener('submit', function (event) {
//         if (!validateInputs()) {
//             event.preventDefault(); // Prevent form submission if validation fails
//         }
//     });

//     for (const key in shipInputs) {
//         shipInputs[key].addEventListener('input', validateInputs);
//     }
// });








function toggleFields() {
    var shipLimit = document.querySelector('input[name="ship_limit"]:checked').value;
    var noOfClassesDiv = document.getElementById("no_of_classes_div");
    var classFrequencyDiv = document.getElementById("class_frequency_div");

    if (shipLimit === "Unlimited") {
        noOfClassesDiv.style.display = "none";
        classFrequencyDiv.style.display = "none";
    } else {
        noOfClassesDiv.style.display = "block";
        classFrequencyDiv.style.display = "block";
    }
}

// Call toggleFields initially to set initial state based on the checked radio button
toggleFields();



function toggleFields() {
    var shipLimit = document.querySelector('input[name="ship_limit"]:checked').value;
    var noOfClassesDiv = document.getElementById("no_of_classes_div");
    var classFrequencyDiv = document.getElementById("class_frequency_div");

    if (shipLimit === "Unlimited") {
        noOfClassesDiv.style.display = "none";
        classFrequencyDiv.style.display = "none";
    } else {
        noOfClassesDiv.style.display = "block";
        classFrequencyDiv.style.display = "block";
    }
}

// Get all radio buttons
var radioButtons = document.querySelectorAll('input[type="radio"]');

// Add click event listener to each radio button
radioButtons.forEach(function (radioButton) {
    radioButton.addEventListener('click', function () {
        toggleFields();
    });
});

// Call toggleFields initially to set initial state based on the checked radio button
toggleFields();




// ======================= password show hide &  manimum 8 character ======================
// Wait for the DOM content to be fully loaded before executing the script
// document.addEventListener('DOMContentLoaded', function () {
//     // Get references to the required DOM elements
//     const rPasswordInput = document.getElementById('password-reset');
//     const cPasswordError = document.getElementById('pass-reset-error');
//     const toggleResetPassword = document.getElementById('toggle_password');
//     const eyeIcon = document.getElementById('eye_icon');

//     // Add event listener to toggle password visibility
//     toggleResetPassword.addEventListener('click', function () {
//         // Toggle the type attribute of the password input field
//         const type = rPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
//         rPasswordInput.setAttribute('type', type);
//         // Change the eye icon based on password visibility
//         eyeIcon.className = type === 'password' ? 'ti ti-eye-off' : 'ti ti-eye';
//     });

//     // Add event listener to validate password input
//     rPasswordInput.addEventListener('input', function () {
//         // Trim any leading or trailing whitespace from the input value
//         const inputValue = rPasswordInput.value.trim();

//         // Check if the input value is empty
//         if (inputValue === '') {
//             cPasswordError.textContent = 'Password cannot be empty.';
//             cPasswordError.style.display = 'block'; // Show the error message
//             rPasswordInput.classList.add('is-invalid'); // Apply CSS class for invalid input
//         }
//         // Check if the input value is less than 8 characters long
//         else if (inputValue.length < 8) {
//             cPasswordError.textContent = 'Password should be at least 8 characters long.';
//             cPasswordError.style.display = 'block'; // Show the error message
//             rPasswordInput.classList.add('is-invalid'); // Apply CSS class for invalid input
//         } else {
//             // If the input value is valid, clear any error messages and CSS classes
//             cPasswordError.textContent = ''; // Clear the error message
//             cPasswordError.style.display = 'none'; // Hide the error message
//             rPasswordInput.classList.remove('is-invalid'); // Remove CSS class for invalid input
//         }
//     });
// });

