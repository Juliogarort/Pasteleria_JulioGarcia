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

// Lógica para agregar un nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['precio'], $_POST['categoria'], $_FILES['imagen'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    // Procesar la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = basename($imagen['name']);
    $rutaImagen = 'public/img/' . $nombreImagen;

    // Mover el archivo a la carpeta de imágenes
    if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
        try {
            // Insertar el producto en la base de datos con la ruta de la imagen
            $sqlInsertar = "INSERT INTO productos (nombre, precio, categoria, imagen) VALUES (:nombre, :precio, :categoria, :imagen)";
            $stmtInsertar = $conexion->prepare($sqlInsertar);
            $stmtInsertar->bindParam(':nombre', $nombre);
            $stmtInsertar->bindParam(':precio', $precio);
            $stmtInsertar->bindParam(':categoria', $categoria);
            $stmtInsertar->bindParam(':imagen', $rutaImagen);
            $stmtInsertar->execute();

            // Redirigir con mensaje de éxito
            header("Location: mainAdmin.php?mensaje=producto_creado");
            exit();
        } catch (PDOException $e) {
            echo "Error al crear el producto: " . $e->getMessage();
        }
    } else {
        echo "Error al subir la imagen.";
    }
}


// Obtener productos de la tabla productos
$sql = "SELECT id, nombre, precio, categoria, imagen FROM productos";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <header id="inicio" class="container d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
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
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
            Crear Producto
        </button>

        <!-- Modal para Crear Producto -->
        <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearProductoModalLabel">Crear Nuevo Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <input type="text" class="form-control" id="categoria" name="categoria" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar Producto</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Dulces Disponibles -->
        <h3 class="mt-4">Dulces Disponibles:</h3>
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
                                <p class="card-text">Categoría: <?= htmlspecialchars($dulce['categoria']); ?></p>
                                <p class="card-text"><strong>Precio: <?= number_format($dulce['precio'], 2); ?>€</strong></p>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?= $dulce['id']; ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="eliminar.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id_producto" value="<?= htmlspecialchars($dulce['id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </form>
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
                                            <input type="text" class="form-control" id="imagen<?= $dulce['id']; ?>" name="imagen" value="<?= htmlspecialchars($dulce['imagen']); ?>">
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
                        <div class="card card1 h-100">
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
                    <h5>Contáctanos</h5>
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