const forms = document.querySelectorAll('form');

function validateInput(input) {
    const inputValue = input.value.trim();
    let isValid = false;
    let errorMessage = '';

    if (input.type == 'text') {
        isValid = /^[a-zA-Z0-9\s]{3,}$/.test(inputValue);
        errorMessage = isValid ? '' : 'Debe tener más de 2 caracteres y solo contener letras y números.';
    } else if (input.type == 'email') {
        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputValue);
        errorMessage = isValid ? '' : 'Debe ser una dirección de correo electrónico válida.';
    } else if (input.type == 'password') {
        isValid = inputValue.length >= 6;
        errorMessage = isValid ? '' : 'Debe tener al menos 6 caracteres.';
    } else if (input.type == 'time') {
        if (input.id.includes('End')) {
            const startTime = document.getElementById(input.id.replace('End', '')).value;
            isValid = startTime < input.value;
            errorMessage = isValid ? '' : 'La hora de fin debe ser después de la de inicio.';
        } else {
            isValid = input.value !== '';
            errorMessage = isValid ? '' : 'Debes poner una hora.';
        }
    }

    if (!isValid) {
        input.classList.add('invalid');
        input.classList.remove('valid');
        showError(input, errorMessage);
    } else {
        input.classList.add('valid');
        input.classList.remove('invalid');
        document.querySelector(`#${input.id}-error`).style.visibility = 'hidden';
    }
}

function showError(input, message) {
    const errorElement = document.querySelector(`#${input.id}-error`);
    errorElement.textContent = message;
    errorElement.style.visibility = 'visible';
}

function validarForm(inputs) {
    let isFormValid = true;

    inputs.forEach(input => {
        validateInput(input);
        if (input.classList.contains('invalid')) {
            isFormValid = false;
        }
    });

    return isFormValid;
}

document.addEventListener('DOMContentLoaded', () => {
    forms.forEach(form => {
        let inputs = form.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], input[type="time"]');

        inputs.forEach(input => {
            input.addEventListener('input', () => validateInput(input));
        });

        form.addEventListener('submit', (e) => {
            console.log(!validarForm(inputs));
            if (!validarForm(inputs)) {
                e.preventDefault();  // Prevent form submission if validation fails
            }
        });
    });
});
