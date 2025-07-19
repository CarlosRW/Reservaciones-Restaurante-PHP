<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_cliente = trim($_POST['nombre_cliente']);
    $fecha = $_POST['fecha'];
    $num_personas = intval($_POST['num_personas']);
    $clave = $_POST['clave'];
    
    // Validaciones 
    $errores = [];
    
    if (empty($nombre_cliente)) {
        $errores[] = "El nombre del cliente es obligatorio.";
    }
    
    if (empty($fecha)) {
        $errores[] = "La fecha es obligatoria.";
    } elseif (strtotime($fecha) < time()) {
        $errores[] = "La fecha no puede ser en el pasado.";
    }
    
    if ($num_personas < 1 || $num_personas > 20) {
        $errores[] = "El número de personas debe ser entre 1 y 20.";
    }
    
    if (empty($clave)) {
        $errores[] = "La clave de verificación es obligatoria.";
    }
    
    if (empty($errores)) {
        // Hash de la clave
        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);
        
        // Insertar en la base de datos
        $stmt = $mysqli->prepare("INSERT INTO reservaciones (nombre_cliente, fecha, num_personas, clave) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre_cliente, $fecha, $num_personas, $clave_hash);
        
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Reservación realizada con éxito. ¡Te esperamos!";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al realizar la reservación. Por favor, intenta nuevamente.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = implode("<br>", $errores);
        $_SESSION['tipo_mensaje'] = "danger";
    }
    
    $mysqli->close();
    header("Location: index.php");
    exit();
}
?>