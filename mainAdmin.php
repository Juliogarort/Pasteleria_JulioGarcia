<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si es admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obtener los datos de sesión
$username = $_SESSION['username'];  // Nombre del usuario (admin)
$dulces = $_SESSION['dulces'] ?? [];  // Dulces de la pastelería (si existen)
$clientes = $_SESSION['clientes'] ?? [];  // Clientes de la pastelería (si existen)
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
    <div class="container mt-5">
        <h1 class="text-success text-center">¡Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>

        <h3 class="mt-4">Dulces Disponibles:</h3>
        <ul class="list-group">
            <?php foreach ($dulces as $dulce): ?>
                <li class="list-group-item">
                    <?php echo "{$dulce['tipo']} - {$dulce['nombre']} ({$dulce['precio']}€)"; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3 class="mt-4">Clientes Registrados:</h3>
        <ul class="list-group">
            <?php 
            if (empty($clientes)) {
                echo "<li class='list-group-item'>No hay clientes registrados.</li>";
            } else {
                foreach ($clientes as $cliente): 
                    // Verificar si 'username' está presente en el array
                    $usernameCliente = isset($cliente['username']) ? $cliente['username'] : 'Desconocido';
            ?>
                <li class="list-group-item">
                    <?php echo "{$cliente['nombre']}  - Tel: {$cliente['telefono']}"; ?>
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
