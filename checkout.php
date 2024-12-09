<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Incluye la clase de conexión a la base de datos
require_once 'public/util/Conexion.php';

// Obtener la conexión
$conexion = Conexion::obtenerInstancia()->obtenerConexion();

// Obtener los datos del usuario y los productos del carrito
$usuario = $_SESSION['usuario'];
$sqlUsuario = "SELECT id FROM clientes WHERE usuario = :usuario";
$stmtUsuario = $conexion->prepare($sqlUsuario);
$stmtUsuario->bindParam(':usuario', $usuario);
$stmtUsuario->execute();
$cliente = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
    $cliente_id = $cliente['id'];
    // Consulta para obtener los productos del carrito y las cantidades agrupadas por producto
    $sqlCarrito = "SELECT 
                    p.nombre AS producto_nombre, 
                    p.precio, 
                    p.id AS producto_id, 
                    SUM(pe.cantidad) AS total_cantidad
                   FROM pedidos pe
                   JOIN productos p ON pe.producto_id = p.id
                   WHERE pe.cliente_id = :cliente_id
                   GROUP BY p.id, p.nombre, p.precio";
    $stmtCarrito = $conexion->prepare($sqlCarrito);
    $stmtCarrito->bindParam(':cliente_id', $cliente_id);
    $stmtCarrito->execute();
    $productosCarrito = $stmtCarrito->fetchAll(PDO::FETCH_ASSOC);
    $totalCarrito = 0;

    foreach ($productosCarrito as $producto) {
        $totalCarrito += $producto['precio'] * $producto['total_cantidad'];
    }

    // Borrar los productos del carrito en la base de datos
    $sqlBorrarCarrito = "DELETE FROM pedidos WHERE cliente_id = :cliente_id";
    $stmtBorrarCarrito = $conexion->prepare($sqlBorrarCarrito);
    $stmtBorrarCarrito->bindParam(':cliente_id', $cliente_id);
    $stmtBorrarCarrito->execute();
} else {
    // Si no existe el usuario, redirige a la página de inicio
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra - Pastelería Julio García</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <div class="container mt-5">
        <!-- Encabezado del Ticket -->
        <div class="text-center mb-5">
            <h3 class="display-4">Ticket de Compra</h3>
            <p class="lead"><strong>Usuario:</strong> <?= htmlspecialchars($usuario); ?></p>
            <p class="text-muted"><strong>Fecha:</strong> <?= date('d-m-Y H:i:s'); ?></p>
        </div>

        <!-- Tabla de Productos -->
        <h4 class="mb-4">Productos Comprados</h4>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productosCarrito as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['producto_nombre']); ?></td>
                        <td><?= $producto['total_cantidad']; ?></td>
                        <td><?= number_format($producto['precio'], 2); ?>€</td>
                        <td><?= number_format($producto['precio'] * $producto['total_cantidad'], 2); ?>€</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Total de la Compra -->
        <div class="row">
            <div class="col-12 text-end">
                <h5 class="text-primary"><strong>Total: <?= number_format($totalCarrito, 2); ?>€</strong></h5>
            </div>
        </div>

        <!-- Botón Volver a la Tienda -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="main.php" class="btn btn-success btn-lg">Volver a la tienda</a>
            </div>
        </div>
    </div>

</body>

</html>
