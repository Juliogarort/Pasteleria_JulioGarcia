<?php
session_start();

// Obtener los datos del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Verificar credenciales
if ($username === 'admin' && $password === 'admin') {
    $_SESSION['username'] = 'admin';

    // Simulación de datos para el administrador
    $_SESSION['dulces'] = [
        ['tipo' => 'Tarta', 'nombre' => 'Tarta de chocolate', 'precio' => 20],
        ['tipo' => 'Galleta', 'nombre' => 'Galletas de avena', 'precio' => 5],
    ];
    $_SESSION['clientes'] = [
        ['nombre' => 'Oc Modus', 'telefono' => '666666666'],
        ['nombre' => 'Jimmy no Fear', 'telefono' => '555555555'],
    ];

    // Redirigir a mainAdmin.php
    header("Location: mainAdmin.php");
    exit();
} elseif ($username === 'usuario' && $password === 'usuario') {
    $_SESSION['username'] = 'usuario';

    // Redirigir a main.php
    header("Location: main.php");
    exit();
} else {
    // Credenciales incorrectas, redirigir al login con mensaje de error
    header("Location: index.php?error=Usuario o contraseña incorrectos.");
    exit();
}
?>
