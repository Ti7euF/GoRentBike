document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const firstName = form.firstName;
    const lastName = form.lastName;
    const email = form.email;
    const password = form.password;
    const confirmPassword = form.confirmPassword;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    const errorFirstName = document.getElementById('errorFirstName');
    const errorLastName = document.getElementById('errorLastName');
    const errorEmail = document.getElementById('errorEmail');
    const errorPassword = document.getElementById('errorPassword');
    const errorConfirmPassword = document.getElementById('errorConfirmPassword');

    submitBtn.disabled = false;

    const nameRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+={}[\]|\\:;"'<>,.?/~`]).+$/;

    function updateSubmitButton() {
        submitBtn.disabled = !isFormValid();
    }

    function isFormValid() {
        return isFirstNameValid() &&
               isLastNameValid() &&
               isEmailValid() &&
               isPasswordValid() &&
               isConfirmPasswordValid();
    }

    // Validaciones
    function isFirstNameValid() {
        return nameRegex.test(firstName.value.trim());
    }

    function isLastNameValid() {
        return nameRegex.test(lastName.value.trim());
    }

    function isEmailValid() {
        return emailRegex.test(email.value.trim());
    }

    function isPasswordValid() {
        return passwordRegex.test(password.value);
    }

    function isConfirmPasswordValid() {
        return password.value === confirmPassword.value;
    }

    //Eventos input
    firstName.addEventListener('input', updateSubmitButton);
    lastName.addEventListener('input', updateSubmitButton);
    email.addEventListener('input', updateSubmitButton);
    password.addEventListener('input', updateSubmitButton);
    confirmPassword.addEventListener('input', updateSubmitButton);

    // Eventos blur
    firstName.addEventListener('blur', function() {
        errorFirstName.style.display = isFirstNameValid() ? 'none' : 'block';
    });

    lastName.addEventListener('blur', function() {
        errorLastName.style.display = isLastNameValid() ? 'none' : 'block';
    });

    email.addEventListener('blur', function() {
        errorEmail.style.display = isEmailValid() ? 'none' : 'block';
    });

    password.addEventListener('blur', function() {
        errorPassword.style.display = isPasswordValid() ? 'none' : 'block';
    });

    confirmPassword.addEventListener('blur', function() {
        errorConfirmPassword.style.display = isConfirmPasswordValid() ? 'none' : 'block';
    });
});