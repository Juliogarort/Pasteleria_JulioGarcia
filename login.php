<?php
session_start();
require_once 'public/util/Conexion.php';

$usuario = $_POST['usuario'] ?? null;
$contraseña = $_POST['contraseña'] ?? null;

if ($usuario && $contraseña) {
    // Usuarios fijos para comprobar sin base de datos
    $usuariosFijos = [
        'usuario' => 'usuario',
        'admin' => 'admin'
    ];

    // Verificar si el usuario es uno de los usuarios fijos
    if (isset($usuariosFijos[$usuario]) && $contraseña === $usuariosFijos[$usuario]) {
        // Si las credenciales coinciden con los usuarios fijos
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = ucfirst($usuario); // Aquí puedes personalizar el nombre
        $_SESSION['cliente_id'] = null; // No hay ID de cliente para estos usuarios
        
        // Redirigir al área correspondiente según el usuario
        if ($usuario === 'admin') {
            header("Location: mainAdmin.php"); // Redirigir a mainAdmin.php para admin
        } else {
            header("Location: main.php"); // Redirigir al área de usuario regular
        }
        exit;
    }

    // Si no es uno de los usuarios fijos, proceder con la consulta en la base de datos
    try {
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        // Consulta para obtener el usuario y la contraseña de la base de datos
        $query = "SELECT id, nombre, usuario, contraseña FROM clientes WHERE usuario = :usuario";
        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        // Comprobar si el usuario existe en la base de datos
        $usuarioBD = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioBD) {
            // Verificar si la contraseña es correcta
            if (password_verify($contraseña, $usuarioBD['contraseña'])) {
                // La contraseña es correcta, iniciar sesión
                $_SESSION['usuario'] = $usuarioBD['usuario'];
                $_SESSION['nombre'] = $usuarioBD['nombre'];
                $_SESSION['cliente_id'] = $usuarioBD['id'];
                header("Location: main.php"); // Redirigir al área de usuario
                exit;
            } else {
                // Contraseña incorrecta
                header("Location: index.php?error=Contraseña incorrecta.");
                exit;
            }
        } else {
            // Usuario no encontrado
            header("Location: index.php?error=Usuario no encontrado.");
            exit;
        }
    } catch (PDOException $e) {
        // Error en la conexión
        header("Location: index.php?error=Error en el servidor. Intenta más tarde.");
        exit;
    }
} else {
    // Redirigir si los campos están vacíos
    header("Location: index.php?error=Por favor, completa todos los campos.");
    exit;
}
?>
