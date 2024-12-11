<?php
$mensajeError = $_GET['error'] ?? '';
?>
<?php
$mensajeError = $_GET['error'] ?? '';
?>
<?php
$mensajeError = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Pastelería</title>
    <link rel="icon" href="public/img/JGO_LogoN.png" type="image/x-icon">

    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="public/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="d-flex flex-column vh-100 justify-content-center align-items-center">
        <!-- Contenedor de la imagen encima del formulario -->
        <div class="mb-4">
            <img src="public/img/JGO_LogoN.png" alt="Logo Pastelería" class="img-fluid" style="max-width: 200px;">
        </div>

        <!-- Tarjeta con el formulario de registro -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Registro de usuario</h4>
                </div>
                <div class="card-body">
                    <!-- Mostrar mensaje de error si existe -->
                    <?php if ($mensajeError): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($mensajeError) ?>
                        </div>
                    <?php endif; ?>

                    <form action="registro.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                            <div id="passwordFeedback" class="mt-2" style="display: none;"></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="submitBtn" class="btn btn-primary w-100" disabled>Registrar</button>
                            <a href="index.php" class="btn btn-secondary w-100 mt-2">Volver al login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
