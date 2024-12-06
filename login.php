<?php
require_once 'public/util/Conexion.php';

// Recibimos los datos del formulario por POST
$usuario = $_POST['usuario'] ?? null;
$contraseña = $_POST['contraseña'] ?? null;

if ($usuario && $contraseña) {
    try {
        // Conexión a la base de datos
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        // Consulta para buscar el usuario
        $query = "SELECT * FROM clientes WHERE usuario = :usuario";
        $stmt = $conexion->prepare($query);

        // Vincular los valores de los parámetros
        $stmt->bindValue(':usuario', $usuario);

        // Ejecutar la consulta
        $stmt->execute();

        // Comprobar si encontramos el usuario
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            // Comparar la contraseña directamente (sin cifrado)
            if ($contraseña === $cliente['contraseña']) {
                echo "Bienvenido, {$cliente['nombre']}!";
                // Aquí podrías redirigir o iniciar sesión para el usuario
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
        echo "Error al conectar con la base de datos: " . $e->getMessage();
    }
} else {
    echo "Por favor, introduce usuario y contraseña.";
}
?>
