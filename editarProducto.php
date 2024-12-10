<?php
require_once 'public/util/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $imagen = $_POST['imagen'];

    $conexion = Conexion::obtenerInstancia()->obtenerConexion();

    $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, categoria = :categoria, imagen = :imagen WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':imagen', $imagen);
    $stmt->bindParam(':id', $idProducto, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: mainAdmin.php?mensaje=producto_actualizado");
    exit();
}
?>
