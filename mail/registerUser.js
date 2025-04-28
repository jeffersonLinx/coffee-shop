document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('newsletterBtn').addEventListener('click', function(event) {

document.getElementById('newsletterBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Esto evita que se recargue la página accidentalmente

    const emailInput = document.getElementById('newsletterEmail');
    const email = emailInput.value.trim();
    const btn = this;

    if (email === '') {
        toastr.error('Por favor ingresa un correo válido.');
        emailInput.focus();
        return;
    }

    btn.disabled = true;
    btn.innerText = "Registrando...";

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'controllers/registrar_cliente.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        btn.disabled = false;
        btn.innerText = "Registrate";

        if (xhr.status === 200) {
            toastr.success('¡Te has registrado exitosamente!');
            emailInput.value = '';
            emailInput.classList.remove('is-invalid');
            emailInput.classList.add('is-valid'); // le ponemos borde verde
        } else if (xhr.status === 409) {
            toastr.warning('Este correo ya está registrado.');
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid'); // borde rojo
            emailInput.select(); // selecciona el texto para corregir rápido
        } else {
            toastr.error('Ocurrió un error. Intenta nuevamente.');
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid');
        }
    };

    xhr.onerror = function() {
        btn.disabled = false;
        btn.innerText = "Registrate";
        toastr.error('No se pudo conectar al servidor.');
        emailInput.classList.remove('is-valid');
        emailInput.classList.add('is-invalid');
    };

    xhr.send('email=' + encodeURIComponent(email));
});


});
});