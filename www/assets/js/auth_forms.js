const $d = document;
const forms = document.querySelectorAll('form');

function validateInput(input) {
    const inputValue = input.value.trim();
    let isValid = false;
    let errorMessage = '';

    if (input.type === 'text') {
        isValid = /^[a-zA-Z0-9]{3,}$/.test(inputValue);
        errorMessage = isValid ? '' : 'Debe tener más de 2 caracteres y solo contener letras y números.';
    } else if (input.type === 'email') {
        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputValue);
        errorMessage = isValid ? '' : 'Debe ser una dirección de correo electrónico válida.';
    } else if (input.type === 'password') {
        isValid = inputValue.length >= 6;
        errorMessage = isValid ? '' : 'Debe tener al menos 6 caracteres.';
    }

    if (!isValid) {
        input.classList.add('invalid');
        input.classList.remove('valid');
        showError(input, errorMessage);
    } else {
        input.classList.add('valid');
        input.classList.remove('invalid');
        $d.querySelector(`#${input.id}-error`).style.visibility = 'hidden';
    }
}

function showError(input, message) {
    const errorElement = $d.querySelector(`#${input.id}-error`);
    errorElement.textContent = message;
    errorElement.style.visibility = 'visible';
}

function checkFormValidity() {
    let isFormValid = true;

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[type="text"], input[type="password"], input[type="email"]');

        inputs.forEach(input => {
            validateInput(input);
            if (input.classList.contains('invalid')) {
                isFormValid = false;
            }
        });
    });

    return isFormValid;
}

$d.addEventListener('DOMContentLoaded', () => {
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[type="text"], input[type="password"], input[type="email"]');

        inputs.forEach(input => {
            input.addEventListener('input', () => validateInput(input));
        });

        form.addEventListener('submit', event => {
            if (!checkFormValidity()) {
                event.preventDefault();
            }
        });
    });
});
