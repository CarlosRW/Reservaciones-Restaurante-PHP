<?php
require_once 'conexion.php';

// Obtener reservaciones existentes para mostrar
$reservaciones = [];
$resultado = $mysqli->query("SELECT id, nombre_cliente, fecha, num_personas FROM reservaciones ORDER BY fecha DESC");
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $reservaciones[] = $fila;
    }
}

// Mostrar mensajes de éxito/error
session_start();
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : '';
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones - Restaurante</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="text-center my-5">
            <h1 class="display-4">Restaurante</h1>
            <p class="lead">¡Haz tu reservación fácil y rápido!</p>
        </header>

        <?php if ($mensaje): ?>
        <div class="alert alert-<?= $tipo_mensaje ?> alert-dismissible fade show" role="alert">
            <?= $mensaje ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Nueva Reservación</h2>
                    </div>
                    <div class="card-body">
                        <form id="formReservacion" action="procesar.php" method="post">
                            <div class="mb-3">
                                <label for="nombre_cliente" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha y hora</label>
                                <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="mb-3">
                                <label for="num_personas" class="form-label">Número de personas</label>
                                <input type="number" class="form-control" id="num_personas" name="num_personas" min="1" max="20" required>
                            </div>
                            <div class="mb-3">
                                <label for="clave" class="form-label">Clave de verificación</label>
                                <input type="password" class="form-control" id="clave" name="clave" required>
                                <small class="text-muted">Esta clave te permitirá modificar o cancelar tu reservación</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Reservar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h2 class="h5 mb-0">Reservaciones recientes</h2>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reservaciones)): ?>
                            <p class="text-muted">No hay reservaciones registradas aún.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Fecha</th>
                                            <th>Personas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reservaciones as $reserva): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($reserva['nombre_cliente']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($reserva['fecha'])) ?></td>
                                            <td><?= $reserva['num_personas'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/validacion.js"></script>
</body>
</html>