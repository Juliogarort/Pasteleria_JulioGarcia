<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si es admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Incluir la clase de conexión a la base de datos
require_once 'public/util/Conexion.php';

// Verificar si se ha enviado el ID del producto
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Obtener la conexión
    $conexion = Conexion::obtenerInstancia()->obtenerConexion();

    // Preparar la consulta para eliminar el producto
    $sql = "DELETE FROM productos WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al administrador a la página principal después de eliminar el producto
        header("Location: mainAdmin.php");
        exit();
    } else {
        echo "Hubo un problema al eliminar el producto.";
    }
} else {
    echo "ID de producto no válido.";
}
?>
