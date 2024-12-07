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

// Consulta para obtener los dulces disponibles
$sql = "SELECT id, nombre, precio, categoria FROM productos";
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
            $cantidad = 1; // Puede ser ampliado para permitir elegir la cantidad

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Pastelería</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <!-- Nombre de la pastelería -->
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">Pastelería Julio García</span>
        </a>

        <!-- Sección de bienvenida, carrito de compras y botón de cerrar sesión -->
        <div class="d-flex align-items-center">
            <span class="fs-6 me-3">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']); ?>!</span>
            <!-- Carrito de la compra -->
            <a href="cart.php" class="btn btn-outline-dark me-3">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
            </a>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </header>

    <div class="container mt-5">
        <!-- Sección de dulces -->
        <h3 class="mb-4">Nuestros Dulces</h3>
        <div class="row">
            <?php if (empty($dulces)): ?>
                <p class="text-center">No hay dulces disponibles.</p>
            <?php else: ?>
                <?php foreach ($dulces as $dulce): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Imagen del dulce">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
