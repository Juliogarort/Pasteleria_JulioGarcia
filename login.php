<?php
// Iniciar la sesión
session_start();

// Recibir datos del formulario
$usuario = $_POST['usuario'] ?? null;
$contraseña = $_POST['contraseña'] ?? null;

if ($usuario && $contraseña) {
    // Si el usuario es 'usuario' y la contraseña también 'usuario', redirigir a main.php
    if ($usuario === 'usuario' && $contraseña === 'usuario') {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = 'Usuario';
        header("Location: main.php");
        exit;
    }

    // Si el usuario es 'admin' y la contraseña también 'admin', redirigir a mainAdmin.php
    if ($usuario === 'admin' && $contraseña === 'admin') {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = 'Admin';
        header("Location: mainAdmin.php");
        exit;
    }

    // Si las credenciales no coinciden con "usuario/usuario" ni "admin/admin"
    echo "Usuario o contraseña incorrectos.";
} else {
    echo "Por favor, completa todos los campos.";
}
?>
