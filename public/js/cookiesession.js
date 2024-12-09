"use strict";

    // Función para crear una cookie
    function setCookie(name, value, minutes) {
        var d = new Date();
        d.setTime(d.getTime() + (minutes * 60 * 1000)); // Establecer la expiración
        var expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Función para obtener el valor de una cookie
    function getCookie(name) {
        var nameEq = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(nameEq) == 0) return c.substring(nameEq.length, c.length);
        }
        return "";
    }

    // Comprobamos si ya existe una cookie
    var SesionActual = getCookie("SesionActual");

    if (!SesionActual) {
        // Si no existe la cookie, la creamos con el momento actual
        setCookie("SesionActual", new Date().getTime(), 30); // La cookie expirará en 30 días
    } else {
        // Si existe, configuramos un temporizador para 2 minutos (120,000 ms)
        setTimeout(function() {
            // Preguntamos al usuario si quiere continuar o cerrar sesión
            var userResponse = confirm("¿Quieres continuar o cerrar sesión?");
            if (!userResponse) {
                window.location.href = "logout.php"; // Redirige a cerrar sesión si elige "No"
            }
        }, 120000); // 2 minutos en milisegundos
    }

    
// ----------------------------------------------------
            // Modo oscuro
// ----------------------------------------------------
// Función para obtener el valor de una cookie por su nombre
function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
}

// Función para establecer una cookie
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000)); // Expira en X días
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Función para cambiar el tema
document.getElementById('theme-toggle').addEventListener('click', () => {
    // Cambiar el tema entre claro y oscuro
    document.body.classList.toggle('dark-theme');

    // Guardar la preferencia en una cookie
    if (document.body.classList.contains('dark-theme')) {
        setCookie('theme', 'dark', 7);  // Cookie con duración de 7 días
        document.getElementById('theme-icon').classList.replace('fa-sun', 'fa-moon');
    } else {
        setCookie('theme', 'light', 7);
        document.getElementById('theme-icon').classList.replace('fa-moon', 'fa-sun');
    }
});

// Al cargar la página, revisar el estado guardado en la cookie
window.addEventListener('DOMContentLoaded', () => {
    const currentTheme = getCookie('theme');
    console.log('Tema actual de la cookie:', currentTheme);  // Añadido para depuración
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-theme');
        document.getElementById('theme-icon').classList.replace('fa-sun', 'fa-moon');
    }
});