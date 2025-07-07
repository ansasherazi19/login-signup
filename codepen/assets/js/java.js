//Signup 
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signupForm");
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");

    function showError(input, message) {
        let errorContainer = input.parentElement.querySelector(".error-message");
        if (errorContainer) {
            errorContainer.textContent = message;
            input.parentElement.classList.add("has-error");
        }
    }

    function clearError(input) {
        let errorContainer = input.parentElement.querySelector(".error-message");
        if (errorContainer) {
            errorContainer.textContent = "";
            input.parentElement.classList.remove("has-error");
        }
    }

    function validateInput(input, regex, message) {
        const value = input.value.trim();
        if (value === "") {
            showError(input, "This field is required.");
            return false;
        } else if (!regex.test(value)) {
            showError(input, message);
            return false;
        } else {
            clearError(input);
            return true;
        }
    }

    function validatePassword() {
        let errorMsg = "";
        const pwd = password.value;

        if (pwd.length < 8) errorMsg += "At least 8 characters. ";
        if (!/[A-Z]/.test(pwd)) errorMsg += "1 uppercase letter. ";
        if (!/\d/.test(pwd)) errorMsg += "1 number. ";
        if (!/[\W_]/.test(pwd)) errorMsg += "1 special character. ";

        if (errorMsg) {
            showError(password, errorMsg);
        } else {
            clearError(password);
        }

        if (confirmPassword.value.length > 0) {
            validatePasswordMatch();
        }
    }

    function validatePasswordMatch() {
        if (password.value !== confirmPassword.value) {
            showError(confirmPassword, "Passwords do not match!");
        } else {
            clearError(confirmPassword);
        }
    }

    username.addEventListener("input", () => {
        validateInput(username, /^[a-zA-Z0-9]{3,20}$/, "Only letters & numbers (3-20 characters).");
    });

    email.addEventListener("input", () => {
        validateInput(email, /^[a-z0-9._%+-]+@[a-z]+\.[a-z]{2,}$/, "Invalid email format.");
    });

    firstName.addEventListener("input", () => {
        validateInput(firstName, /^[a-zA-Z]{2,30}$/, "Only letters (2-30 characters).");
    });

    lastName.addEventListener("input", () => {
        validateInput(lastName, /^[a-zA-Z]{2,30}$/, "Only letters (2-30 characters).");
    });

    password.addEventListener("input", validatePassword);
    confirmPassword.addEventListener("input", validatePasswordMatch);

    form.addEventListener("submit", function (event) {
        let isValid = true;

        if (!validateInput(username, /^[a-zA-Z0-9]{3,20}$/, "Only letters & numbers (3-20 characters).")) isValid = false;
        if (!validateInput(email, /^[a-z0-9._%+-]+@[a-z]+\.[a-z]{2,}$/, "Invalid email format.")) isValid = false;
        if (!validateInput(firstName, /^[a-zA-Z]{2,30}$/, "Only letters (2-30 characters).")) isValid = false;
        if (!validateInput(lastName, /^[a-zA-Z]{2,30}$/, "Only letters (2-30 characters).")) isValid = false;
        if (password.parentElement.classList.contains("has-error")) isValid = false;
        if (confirmPassword.parentElement.classList.contains("has-error")) isValid = false;

        if (!isValid) {
            event.preventDefault();
            alert("Please fix the errors before submitting.");
        }
    });

    // Prevent copy from password field
    password.addEventListener("copy", function (event) {
        event.preventDefault();
        navigator.clipboard.writeText(password.value).catch(err => console.error("Copy failed:", err));
    });

    // Prevent paste into confirm password field
    confirmPassword.addEventListener("paste", function (event) {
        event.preventDefault();
        setTimeout(() => {
            confirmPassword.value = password.value;
            validatePasswordMatch();
        }, 50);
    });

    // Toggle password visibility function
    window.togglePassword = function (fieldId, iconSpan) {
        const field = document.getElementById(fieldId);
        const icon = iconSpan.querySelector("i");

        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    };
});













// //signin

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signinForm");
    const email = document.getElementById("signinEmail");
    const password = document.getElementById("signinPassword");

    function showError(input, message) {
        const errorContainer = input.parentElement.querySelector(".error-message");
        errorContainer.textContent = message;
        input.classList.add("has-error");
    }

    function clearError(input) {
        const errorContainer = input.parentElement.querySelector(".error-message");
        errorContainer.textContent = "";
        input.classList.remove("has-error");
    }

    function validateInput(input, regex, message) {
        if (!regex.test(input.value.trim())) {
            showError(input, message);
            return false;
        } else {
            clearError(input);
            return true;
        }
    }

    function validatePassword(input) {
        let errorMsg = "";
        const val = input.value;

        if (val.length < 8) errorMsg += "Min 8 characters. ";
        if (!/[A-Z]/.test(val)) errorMsg += "1 uppercase letter. ";
        if (!/\d/.test(val)) errorMsg += "1 number. ";
        if (!/[\W_]/.test(val)) errorMsg += "1 special char. ";

        if (errorMsg) {
            showError(input, errorMsg);
            return false;
        } else {
            clearError(input);
            return true;
        }
    }

    form.addEventListener("submit", function (event) {
        const emailValid = validateInput(email, /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i, "Invalid email format.");
        const passwordValid = validatePassword(password);

        if (!emailValid || !passwordValid) {
            event.preventDefault();
            alert("Incorrect Email or Password!");
        } else {
            alert("Signed in successfully!");
            form.reset();
        }
    });

    window.togglePassword = function (fieldId, iconSpan) {
        const field = document.getElementById(fieldId);
        const icon = iconSpan.querySelector("i");

        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    };
});
















// // Forget Password Form Handle
//     const forgetForm = document.querySelector("#forgetForm");
  //const errorMessage = document.querySelector(".error-message");
//     if (forgetForm) {
//         forgetForm.addEventListener("submit", function (event) {
//             const recoveryEmail = document.querySelector("input[name='recoveryemail']").value.trim();
//             const emailRegex = /^[a-z0-9._%+-]+@[a-z]+\.[a-z]{2,}$/;

//             if (!emailRegex.test(recoveryEmail)) {
//                 event.preventDefault();
//                 alert("Invalid Recovery Email!");
//             }
//         });
//     }































//Resetpass

document.addEventListener("DOMContentLoaded", function () {
    const resetForm = document.getElementById("resetForm");
    const newPassword = document.getElementById("newPassword");
    const confirmNewPassword = document.getElementById("confirmNewPassword");

    function showError(input, message) {
        const inputBox = input.closest(".password-container");
        const errorMessage = inputBox.querySelector(".error-message");
        errorMessage.textContent = message;
        errorMessage.style.display = "block";
        inputBox.classList.add("has-error");
    }

    function clearError(input) {
        const inputBox = input.closest(".password-container");
        const errorMessage = inputBox.querySelector(".error-message");
        errorMessage.textContent = "";
        errorMessage.style.display = "none";
        inputBox.classList.remove("has-error");
    }

    function validatePassword() {
        const passwordValue = newPassword.value;
        const confirmPasswordValue = confirmNewPassword.value;
        let isValid = true;

        clearError(newPassword);
        clearError(confirmNewPassword);

        if (passwordValue.length < 8) {
            showError(newPassword, "Password must be at least 8 characters long.");
            isValid = false;
        } else if (!/[A-Z]/.test(passwordValue)) {
            showError(newPassword, "Password must contain at least one uppercase letter.");
            isValid = false;
        } else if (!/[a-z]/.test(passwordValue)) {
            showError(newPassword, "Password must contain at least one lowercase letter.");
            isValid = false;
        } else if (!/[0-9]/.test(passwordValue)) {
            showError(newPassword, "Password must contain at least one number.");
            isValid = false;
        } else if (!/[!@#$%^&*]/.test(passwordValue)) {
            showError(newPassword, "Password must contain at least one special character (!@#$%^&*).");
            isValid = false;
        }

        if (confirmPasswordValue !== "" && passwordValue !== confirmPasswordValue) {
            showError(confirmNewPassword, "Passwords do not match.");
            isValid = false;
        }

        return isValid;
    }

    resetForm.addEventListener("input", validatePassword);
    resetForm.addEventListener("submit", function (e) {
        if (!validatePassword()) {
            e.preventDefault();
        }
    });

    // Make togglePassword globally available
    window.togglePassword = function (fieldId, icon) {
        const passwordField = document.getElementById(fieldId);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        } else {
            passwordField.type = "password";
            icon.innerHTML = '<i class="fa-solid fa-eye"></i>';
        }
    };

    // Restrict Copy-Paste
    newPassword.addEventListener("copy", function (event) {
        event.preventDefault();
        navigator.clipboard.writeText(newPassword.value).catch(err => console.error("Copy failed:", err));
    });

    confirmNewPassword.addEventListener("paste", function (event) {
        event.preventDefault();
        setTimeout(() => {
            confirmNewPassword.value = newPassword.value;
            validatePassword();
        }, 50);
    });
});

    