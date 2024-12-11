<?php
// Obtener el mensaje de error si existe
$mensajeError = $_GET['error'] ?? '';
?>
<?php
// Obtener el mensaje de error si existe
$mensajeError = $_GET['error'] ?? '';
?>
<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pastelería</title>
    <link rel="icon" href="public/img/JGO_LogoN.png" type="image/x-icon">

    <!-- Vincular archivo CSS -->
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex flex-column vh-100 justify-content-center align-items-center">
        <div class="mb-4">
            <img src="public/img/JGO_LogoN.png" alt="Logo Pastelería" class="img-fluid" style="max-width: 200px;">
        </div>

        <!-- Tarjeta con el formulario -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Inicio de sesión</h4>
                </div>
                <div class="card-body">
                    <!-- Mostrar mensaje de error si existe -->
                    <?php if ($mensajeError): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($mensajeError) ?>
                        </div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100 mb-2">Iniciar sesión</button>
                            <a href="index2.php" class="btn btn-secondary w-100">Registrarse</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
