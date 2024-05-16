
const id = (id) => document.getElementById(id)
const loginForm = id('login-form'), adminMail = id("email"), adminPass = id("password"), emailError = id("emailError"), passwordError = id("passwordError")

function showError(input, message) {
    const formBox = input.parentElement;
    const errorMessage = formBox.querySelector('.error-message');
    errorMessage.innerText = message;
}

function clearError(input) {
    const formBox = input.parentElement;
    const errorMessage = formBox.querySelector('.error-message');
    errorMessage.innerText = '';
}

function validateEmail(input) {
    const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
    if (input.value.trim() === '') {
        showError(input, 'Email is required');
        return false;
    } else if (!emailRegex.test(input.value.trim())) {
        showError(input, 'Invalid email address');
        return false;
    } else {
        clearError(input);
        return true;
    }
}

function validatePassword(input) {
    if (input.value.trim() === '') {
        showError(input, 'Password is required');
        return false;
    } else if (input.value.trim().length < 6) {
        showError(input, 'Password must be at least 6 digit long');
        return false;
    } else {
        clearError(input);
        return true;
    }
}

function validateForm() {
    let isEmailValid = validateEmail(adminMail);
    let isPasswordValid = validatePassword(adminPass);

    return isEmailValid && isPasswordValid;
}

adminMail.addEventListener('blur', () => validateEmail(adminMail));
adminPass.addEventListener('blur', () => validatePassword(adminPass));

loginForm.addEventListener('submit', (e) => {
    clearError(adminMail);
    clearError(adminPass);

    if (!validateForm()) {
        e.preventDefault(); 
    }
});