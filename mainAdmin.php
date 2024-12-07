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

// Consulta para obtener los productos disponibles
$sql = "SELECT nombre, precio, tipo FROM productos";
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class=" container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">Pastelería Julio García</span>
        </a>

        <div class="d-flex align-items-center">
            <span class="fs-6 me-3">Bienvenido, <?= htmlspecialchars($usuario); ?>!</span>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </header>

    <div class="container mt-5">


        <h3 class="mt-4">Dulces Disponibles:</h3>
        <div class="row">
            <?php if (empty($dulces)): ?>
                <p>No hay dulces disponibles.</p>
            <?php else: ?>
                <?php foreach ($dulces as $dulce): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Imagen del dulce">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($dulce['nombre']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($dulce['tipo']); ?></p>
                                <p class="card-text"><strong>Precio: <?php echo number_format($dulce['precio'], 2); ?>€</strong></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h3 class="mt-4">Clientes Registrados:</h3>
        <ul class="list-group">
            <?php 
            if (empty($clientes)) {
                echo "<li class='list-group-item'>No hay clientes registrados.</li>";
            } else {
                foreach ($clientes as $cliente): 
            ?>
                <li class="list-group-item">
                    <?php echo "{$cliente['nombre']} - Usuario: {$cliente['usuario']} "; ?>
                </li>
            <?php endforeach; 
            } ?>
        </ul>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
