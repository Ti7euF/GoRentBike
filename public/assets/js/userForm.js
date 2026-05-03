document.addEventListener('DOMContentLoaded', () => {
    const firstName = document.getElementById('firstName');
    const lastName = document.getElementById('lastName');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const submitBtn = document.querySelector('button[type="submit"]');

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
        const baseValid =
            isFirstNameValid() &&
            isLastNameValid() &&
            isEmailValid();

        //Si no hay contraseña (no edita su propia cuenta)
        if (!password) return baseValid;

        //Si hay contraseña pero está vacío. Se permite actualizar sin contraseña
        if (password.value.trim() === '' && confirmPassword.value.trim() === '') {
            return baseValid;
        }

        //Si hay contraseña validar todo
        return baseValid && isPasswordValid() && isConfirmPasswordValid();
    }

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
        if (!password) return true;
        if (password.value.trim() === '') return true;
        return passwordRegex.test(password.value);
    }

    function isConfirmPasswordValid() {
        if (!confirmPassword) return true;
        if (password.value.trim() === '' && confirmPassword.value.trim() === '') return true;
        return password.value === confirmPassword.value;
    }

    //Eventos input
    firstName.addEventListener('input', updateSubmitButton);
    lastName.addEventListener('input', updateSubmitButton);
    email.addEventListener('input', updateSubmitButton);
    if (password) password.addEventListener('input', updateSubmitButton);
    if (confirmPassword) confirmPassword.addEventListener('input', updateSubmitButton);


    //Eventos blur
    firstName.addEventListener('blur', () => {
        errorFirstName.style.display = isFirstNameValid() ? 'none' : 'block';
    });

    lastName.addEventListener('blur', () => {
        errorLastName.style.display = isLastNameValid() ? 'none' : 'block';
    });

    email.addEventListener('blur', () => {
        errorEmail.style.display = isEmailValid() ? 'none' : 'block';
    });

    if (password) {
        password.addEventListener('blur', () => {
            errorPassword.style.display = isPasswordValid() ? 'none' : 'block';
        });

        confirmPassword.addEventListener('blur', () => {
            errorConfirmPassword.style.display = isConfirmPasswordValid() ? 'none' : 'block';
        });
    }
});