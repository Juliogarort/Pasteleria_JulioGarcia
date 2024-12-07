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
$sql = "SELECT nombre, precio, categoria FROM productos";
$stmt = $conexion->prepare($sql);
$stmt->execute();

// Recuperar los productos
$dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Pastelería</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <!-- Nombre de la pastelería -->
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">Pastelería Julio García</span>
        </a>

        <!-- Sección de bienvenida y botón de cerrar sesión -->
        <div class="d-flex align-items-center">
            <span class="fs-6 me-3">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']); ?>!</span>
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
