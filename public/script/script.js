const id = (id) => document.getElementById(id);

const form = id("form"),
  nameInput = id("name"),
  lastnameInput = id("lastname"),
  emailInput = id("email"),
  numberInput = id("number"), 
  passwordInput = id("password"), 
  submitBtn = id("submit");

const nameError = id("nameError"),
  lastnameError = id("lastnameError"),
  emailError = id("emailError"),
  numError = id("numError"), 
  passwordError = id("passwordError")

function showError(input, message) {
  const formBox = input.parentElement;
  const errorMessage = formBox.querySelector(".error-message");
  errorMessage.innerText = message;
}

function clearError(input) {
  const formBox = input.parentElement;
  const errorMessage = formBox.querySelector(".error-message");
  errorMessage.innerText = "";
}

function validateName(input) {
  if (input.value.trim() === "") {
    showError(input, "This field is required");
    return false;
  } else {
    clearError(input);
    return true;
  }
}

function validateEmail(input) {
  const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
  if (input.value.trim() === "") {
    showError(input, "Email is required");
    return false;
  } else if (!emailRegex.test(input.value.trim())) {
    showError(input, "Invalid email address");
    return false;
  } else {
    clearError(input);
    return true;
  }
}

function validateNumber(input) {
  const numberRegex = /^\d{10}$/;
  if (input.value.trim() === "") {
    showError(input, "Mobile number is required");
    return false;
  } else if (!numberRegex.test(input.value.trim())) {
    showError(input, "Invalid mobile number (must be a 10-digit number)");
    return false;
  } else {
    clearError(input);
    return true;
  }
}

function validatePassword(input) {
  if (input.value.trim() === "") {
    showError(input, "Password is required");
    return false;
  } else if (input.value.trim().length < 6) {
    showError(input, "Password must be at least 6 digit long");
    return false;
  } else {
    clearError(input);
    return true;
  }
}
 
 

function validateForm() {
  let isNameValid = validateName(nameInput);
  let isLastNameValid = validateName(lastnameInput);
  let isEmailValid = validateEmail(emailInput);
  let isNumberValid = validateNumber(numberInput); 
  let isPasswordValid = validatePassword(passwordInput); 

  return (
    isNameValid &&
    isLastNameValid &&
    isEmailValid &&
    isNumberValid && 
    isPasswordValid
  );
}

nameInput.addEventListener("blur", () => validateName(nameInput));
lastnameInput.addEventListener("blur", () => validateName(lastnameInput));
emailInput.addEventListener("blur", () => validateEmail(emailInput));
numberInput.addEventListener("blur", () => validateNumber(numberInput));  
passwordInput.addEventListener("blur", () => validatePassword(passwordInput)); 

form.addEventListener("submit", (e) => {
  clearError(nameInput);
  clearError(lastnameInput);
  clearError(emailInput); 
  clearError(numberInput);
  clearError(passwordInput); 

  // Validate the form
  if (!validateForm()) {
    e.preventDefault();
  }
});


// Pawan