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
    <header id="inicio" class= "container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
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
        <h3 class="mt-4 text-center">Añadir Nuevo Producto</h3>
        <form method="POST">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                <label for="producto" class="form-label mb-0">Seleccionar Producto</label>
                <select class="form-select w-auto" id="producto" name="producto" required>
                    <option value="">Seleccionar Producto</option>
                    <?php foreach ($productosAdmin as $productoAdmin): ?>
                        <option value="<?= htmlspecialchars($productoAdmin['id']); ?>">
                            <?= htmlspecialchars($productoAdmin['nombre_producto']); ?> - <?= number_format($productoAdmin['precio'], 2); ?>€
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-primary">Añadir Producto</button>
            </div>
        </form>






        <!-- Dulces Disponibles -->
        <h3 class="mt-4" >Dulces Disponibles:</h3>
        <div class="row">
            <?php if (empty($dulces)): ?>
                <p>No hay dulces disponibles.</p>
            <?php else: ?>
                <?php foreach ($dulces as $dulce): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card card1">
                            <img src="<?= htmlspecialchars($dulce['imagen']); ?>" class="card-img-top" alt="<?= htmlspecialchars($dulce['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($dulce['nombre']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($dulce['categoria']); ?></p>
                                <p class="card-text"><strong>Precio: <?= number_format($dulce['precio'], 2); ?>€</strong></p>
                                <!-- Contenedor flex para botones -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <form action="eliminar.php" method="POST">
                                        <input type="hidden" name="id_producto" value="<?= htmlspecialchars($dulce['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                    </form>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?= $dulce['id']; ?>">Editar</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Modal para Editar Producto -->
                    <div class="modal fade" id="editarModal<?= $dulce['id']; ?>" tabindex="-1" aria-labelledby="editarModalLabel<?= $dulce['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel<?= $dulce['id']; ?>">Editar Producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="editarProducto.php">
                                    <div class="modal-body">
                                        <input type="hidden" name="id_producto" value="<?= $dulce['id']; ?>">
                                        <div class="mb-3">
                                            <label for="nombre<?= $dulce['id']; ?>" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre<?= $dulce['id']; ?>" name="nombre" value="<?= htmlspecialchars($dulce['nombre']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio<?= $dulce['id']; ?>" class="form-label">Precio</label>
                                            <input type="number" class="form-control" id="precio<?= $dulce['id']; ?>" name="precio" value="<?= htmlspecialchars($dulce['precio']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="categoria<?= $dulce['id']; ?>" class="form-label">Categoría</label>
                                            <input type="text" class="form-control" id="categoria<?= $dulce['id']; ?>" name="categoria" value="<?= htmlspecialchars($dulce['categoria']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imagen<?= $dulce['id']; ?>" class="form-label">Imagen (URL)</label>
                                            <input type="text" class="form-control" id="imagen<?= $dulce['id']; ?>" name="imagen" value="<?= htmlspecialchars($dulce['imagen']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- Listado de Usuarios Registrados -->
        <h3 class="mt-5">Usuarios Registrados:</h3>
        <div class="row">
            <?php if (empty($clientes)): ?>
                <p>No hay usuarios registrados.</p>
            <?php else: ?>
                <?php foreach ($clientes as $cliente): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($cliente['nombre']); ?></h5>
                                <p class="card-text"><strong>Usuario:</strong> <?= htmlspecialchars($cliente['usuario']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>Sobre Nosotros</h5>
                    <p>En Pastelería Julio García, ofrecemos los mejores dulces hechos con cariño y los mejores ingredientes.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Enlaces Útiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#inicio" class="text-white text-decoration-none">Inicio</a></li>
                        <li><a href="#inicio" class="text-white text-decoration-none">Productos</a></li>
                        <li><a href="#inicio" class="text-white text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contactanos</h5>
                    <p>Email: contacto@pasteleriajuliogarcia.com</p>
                    <p>Teléfono: +34 123 456 789</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <hr class="my-4">
                    <p>&copy; 2024 Pastelería Julio García. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>


</body>

</html>