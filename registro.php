<?php
require_once 'public/util/Conexion.php';

$nombre = $_POST['nombre'] ?? null;
$usuario = $_POST['usuario'] ?? null;
$contraseña = $_POST['contraseña'] ?? null;

if ($nombre && $usuario && $contraseña) {
    try {
        $regex = '/^(?=.*[a-zA-Z])(?=.*\d).+$/';
        if (preg_match($regex, $contraseña)) {
            $conexion = Conexion::obtenerInstancia()->obtenerConexion();
            $hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);

            $query = "INSERT INTO clientes (nombre, usuario, contraseña) VALUES (:nombre, :usuario, :contrasena)";
            $stmt = $conexion->prepare($query);

            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', $hashedPassword, PDO::PARAM_STR);

            $stmt->execute();

            // Iniciar sesión y redirigir a main.php
            session_start();
            $_SESSION['usuario'] = $usuario; // Guardar el usuario en la sesión
            header("Location: main.php");
            exit; // Detener la ejecución después de la redirección
        } else {
            echo "La contraseña debe contener al menos una letra y un número.";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "El usuario ya existe.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Por favor, completa todos los campos.";
}
?>
