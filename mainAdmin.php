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

$sql = "SELECT id, nombre, precio, categoria, imagen FROM productos";
$stmt = $conexion->prepare($sql);
$stmt->execute();

// Recuperar los productos
$dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se han obtenido productos
if (empty($dulces)) {
    echo "No se han encontrado productos.";
} else {
    // Almacenar los productos en la sesión para que estén disponibles en la vista
    $_SESSION['dulces'] = $dulces;
}

// Consulta para obtener los clientes registrados
$sqlClientes = "SELECT nombre, usuario FROM clientes";
$stmtClientes = $conexion->prepare($sqlClientes);
$stmtClientes->execute();

// Recuperar los clientes
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Admin</title>
    <link rel="stylesheet" href="public/css/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class=" container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">Pastelería Julio García</span>
        </a>

        <div class="d-flex align-items-center">
            <span class="fs-6 me-3">Bienvenido, <?= htmlspecialchars($usuario); ?>!</span>
            <!-- Carrito de compra con Font Awesome -->
            <a href="cart.php" class="btn btn-outline-dark me-3">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
            </a>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </header>

    <div class="container mt-5">
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
            <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                <input type="hidden" name="id_producto" value="<?= $dulce['id']; ?>">
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Clientes Registrados -->
        <h3 class="mt-4">Clientes Registrados:</h3>
        <div class="row">
            <?php 
            if (empty($clientes)) {
                echo "<p>No hay clientes registrados.</p>";
            } else {
                foreach ($clientes as $cliente): 
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($cliente['nombre']); ?></h5>
                            <p class="card-text"><strong>Usuario: </strong><?php echo htmlspecialchars($cliente['usuario']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; 
            } ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
