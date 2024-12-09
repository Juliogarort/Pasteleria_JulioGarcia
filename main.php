<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

require_once 'public/util/Conexion.php';

// Obtener la conexión
$conexion = Conexion::obtenerInstancia()->obtenerConexion();

// Consulta para obtener los dulces disponibles
$sql = "SELECT id, nombre, precio, categoria, imagen FROM productos";
$stmt = $conexion->prepare($sql);
$stmt->execute();

// Recuperar los productos
$dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el formulario ha sido enviado para añadir un producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    if (isset($_SESSION['usuario'])) {
        // Obtener el cliente_id del usuario logueado
        $usuario = $_SESSION['usuario'];
        $sqlUsuario = "SELECT id FROM clientes WHERE usuario = :usuario";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':usuario', $usuario);
        $stmtUsuario->execute();
        $cliente = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            $cliente_id = $cliente['id'];
            $producto_id = $_POST['producto_id'];
            $cantidad = 1;

            // Insertar el pedido en la tabla de pedidos
            $sqlPedido = "INSERT INTO pedidos (cliente_id, producto_id, cantidad) VALUES (:cliente_id, :producto_id, :cantidad)";
            $stmtPedido = $conexion->prepare($sqlPedido);
            $stmtPedido->bindParam(':cliente_id', $cliente_id);
            $stmtPedido->bindParam(':producto_id', $producto_id);
            $stmtPedido->bindParam(':cantidad', $cantidad);
            $stmtPedido->execute();

            // Redirigir para evitar reenvío del formulario
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Verificar si el formulario ha sido enviado para eliminar un producto del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto_id'])) {
    if (isset($_SESSION['usuario'])) {
        // Obtener el cliente_id del usuario logueado
        $usuario = $_SESSION['usuario'];
        $sqlUsuario = "SELECT id FROM clientes WHERE usuario = :usuario";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':usuario', $usuario);
        $stmtUsuario->execute();
        $cliente = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            $cliente_id = $cliente['id'];
            $producto_id = $_POST['eliminar_producto_id'];

            // Eliminar el producto del carrito (de la tabla de pedidos)
            $sqlEliminar = "DELETE FROM pedidos WHERE cliente_id = :cliente_id AND producto_id = :producto_id LIMIT 1";
            $stmtEliminar = $conexion->prepare($sqlEliminar);
            $stmtEliminar->bindParam(':cliente_id', $cliente_id);
            $stmtEliminar->bindParam(':producto_id', $producto_id);
            $stmtEliminar->execute();

            // Redirigir para evitar reenvío del formulario
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Obtener la cantidad de artículos en el carrito para el usuario actual
$contadorCarrito = 0;
$productosCarrito = [];
$totalCarrito = 0;

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    // Obtener el cliente_id del usuario logueado
    $sqlUsuario = "SELECT id FROM clientes WHERE usuario = :usuario";
    $stmtUsuario = $conexion->prepare($sqlUsuario);
    $stmtUsuario->bindParam(':usuario', $usuario);
    $stmtUsuario->execute();
    $cliente = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $cliente_id = $cliente['id'];
        // Consulta actualizada para obtener los productos del carrito y las cantidades agrupadas por producto
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

        foreach ($productosCarrito as $producto) {
            $contadorCarrito += $producto['total_cantidad'];
            $totalCarrito += $producto['precio'] * $producto['total_cantidad'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Pastelería</title>
    
    <!-- Vincular archivo CSS -->
    <link rel="stylesheet" href="public/css/style.css">

    <!-- Vincular archivo JS de cookiesession -->
    <script defer src="public/js/cookiesession.js"></script>

    <!-- Vincular FontAwesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Vincular Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vincular Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>



<body>
    <header class="container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
        <span class="fs-4">Pastelería Julio García</span>
        </a>
        <div class="d-flex align-items-center">
            <span class="fs-6 me-3">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']); ?>!</span>
            <button class="btn btn-outline-dark me-3" data-bs-toggle="modal" data-bs-target="#cartModal">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
                <?php if ($contadorCarrito > 0): ?>
                    <span class="badge bg-primary"><?= $contadorCarrito; ?></span>
                <?php endif; ?>
            </button>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>

            <!-- Botón para cambiar entre modo claro y oscuro -->
            <button id="theme-toggle" class="btn btn-outline-dark">
                <i id="theme-icon" class="fas fa-sun"></i>
            </button>
        </div>
    </header>


    <div class="container mt-5">
        <h3 class="mb-4">Nuestros Dulces</h3>
        <div class="row">
            <?php if (empty($dulces)): ?>
                <p class="text-center">No hay dulces disponibles.</p>
            <?php else: ?>
                <?php foreach ($dulces as $dulce): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($dulce['imagen']); ?>" class="card-img-top" alt="Imagen de <?= htmlspecialchars($dulce['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($dulce['nombre']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($dulce['categoria']); ?></p>
                                <p class="card-text"><strong>Precio: <?= number_format($dulce['precio'], 2); ?>€</strong></p>
                                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="producto_id" value="<?= $dulce['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal del Carrito -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Tu Carrito de Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (empty($productosCarrito)): ?>
                        <p>No tienes productos en el carrito.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($productosCarrito as $producto): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="me-3"><?= htmlspecialchars($producto['producto_nombre']); ?> x <?= $producto['total_cantidad']; ?></span>
                                    <div class="d-flex ms-auto align-items-center">
                                        <span class="badge bg-primary me-2"><?= number_format($producto['precio'] * $producto['total_cantidad'], 2); ?>€</span>
                                        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                                            <input type="hidden" name="eliminar_producto_id" value="<?= $producto['producto_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <h5 class="me-3">Total: <?= number_format($totalCarrito, 2); ?>€</h5>
                </div>
            </div>
        </div>
    </div>

</body>

</html>