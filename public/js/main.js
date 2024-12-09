"use strict";

const passwordInput = document.getElementById('contraseña');
const passwordFeedback = document.getElementById('passwordFeedback');
const submitBtn = document.getElementById('submitBtn');
const regex = /^(?=.*[a-zA-Z])(?=.*\d).+$/;

passwordInput.addEventListener('input', () => {
    const password = passwordInput.value;

    if (regex.test(password)) {
        passwordFeedback.style.display = 'none'; // Oculta el mensaje si la contraseña es válida
        submitBtn.disabled = false;
    } else {
        passwordFeedback.textContent = 'La contraseña debe contener al menos una letra y un número.';
        passwordFeedback.style.display = 'block'; // Muestra el mensaje solo si es inválida
        passwordFeedback.className = 'text-danger';
        submitBtn.disabled = true;
    }
});


