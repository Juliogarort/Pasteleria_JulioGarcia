<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si es admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$usuario = $_SESSION['usuario'];  // Nombre del usuario (admin)

// Incluye la clase de conexión a la base de datos
require_once 'public/util/Conexion.php';

// Obtener la conexión
$conexion = Conexion::obtenerInstancia()->obtenerConexion();

// Lógica para agregar un producto seleccionado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto'])) {
    $idProducto = $_POST['producto'];

    // Obtener información del producto seleccionado en administradorProducto
    $sqlProducto = "SELECT nombre_producto, precio, categoria, imagen FROM administradorProducto WHERE id = :id";
    $stmtProducto = $conexion->prepare($sqlProducto);
    $stmtProducto->bindParam(':id', $idProducto, PDO::PARAM_INT);
    $stmtProducto->execute();
    $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // Insertar el producto en la tabla `productos`
        $sqlInsertar = "INSERT INTO productos (nombre, precio, categoria, imagen) VALUES (:nombre, :precio, :categoria, :imagen)";
        $stmtInsertar = $conexion->prepare($sqlInsertar);
        $stmtInsertar->bindParam(':nombre', $producto['nombre_producto']);
        $stmtInsertar->bindParam(':precio', $producto['precio']);
        $stmtInsertar->bindParam(':categoria', $producto['categoria']);
        $stmtInsertar->bindParam(':imagen', $producto['imagen']);
        $stmtInsertar->execute();

        // Redirigir con mensaje de éxito
        header("Location: mainAdmin.php?mensaje=producto_agregado");
        exit();
    } else {
        echo "Error: Producto no encontrado.";
    }
}

// Obtener productos de la tabla productos
$sql = "SELECT id, nombre, precio, categoria, imagen FROM productos";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener productos disponibles en administradorProducto
$sqlAdminProductos = "SELECT id, nombre_producto, precio, categoria, imagen FROM administradorProducto";
$stmtAdminProductos = $conexion->prepare($sqlAdminProductos);
$stmtAdminProductos->execute();
$productosAdmin = $stmtAdminProductos->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los clientes registrados
$sqlClientes = "SELECT nombre, usuario FROM clientes";
$stmtClientes = $conexion->prepare($sqlClientes);
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Admin</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="icon" href="public/img/JGO_LogoN.png" type="image/x-icon">

    <script defer src="public/js/main.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Header -->
    <header class=" container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="public/img/JGO_LogoN.png" alt="Logo de la pastelería" class="img-fluid me-2" width="40" height="40">

            <span class="fs-4">Pastelería Julio García</span>
        </a>
        <div class="d-flex align-items-center">
            <span class="fs-6 me-3">Bienvenido, <?= htmlspecialchars($usuario); ?>!</span>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </header>

    <div class="container mt-5">
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'producto_agregado'): ?>
            <div class="alert alert-success">¡Producto agregado exitosamente!</div>
        <?php endif; ?>

        <!-- Formulario para seleccionar un nuevo producto -->
        <h3 class="mt-4">Añadir Nuevo Producto</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="producto" class="form-label">Seleccionar Producto</label>
                <select class="form-select" id="producto" name="producto" required>
                    <option value="">Seleccionar Producto</option>
                    <?php foreach ($productosAdmin as $productoAdmin): ?>
                        <option value="<?= htmlspecialchars($productoAdmin['id']); ?>">
                            <?= htmlspecialchars($productoAdmin['nombre_producto']); ?> - <?= number_format($productoAdmin['precio'], 2); ?>€
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-primary">Añadir Producto</button>
        </form>

        <!-- Dulces Disponibles -->
        <h3 class="mt-4">Dulces Disponibles:</h3>
<div class="row">
    <?php if (empty($dulces)): ?>
        <p>No hay dulces disponibles.</p>
    <?php else: ?>
        <?php foreach ($dulces as $dulce): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= htmlspecialchars($dulce['imagen']); ?>" class="card-img-top" alt="Imagen de <?= htmlspecialchars($dulce['nombre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($dulce['nombre']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($dulce['categoria']); ?></p>
                        <p class="card-text"><strong>Precio: <?= number_format($dulce['precio'], 2); ?>€</strong></p>
                        <!-- Botón de eliminar -->
                        <form action="eliminar.php" method="POST" class="mt-2">
                            <input type="hidden" name="id_producto" value="<?= htmlspecialchars($dulce['id']); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

    </div>
</body>
</html>
