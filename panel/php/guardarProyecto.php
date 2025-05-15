<?php
session_start();
include '../../config/config.php'; // <-- Esto define $pdo directamente

// Verificar si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreProyecto'] ?? '';
    $descripcion = $_POST['descripcionProyecto'] ?? '';
    $fechaInicio = $_POST['fechaInicio'] ?? '';
    $fechaFin = $_POST['fechaFin'] ?? '';
    $icono = $_POST['selectedIcon'] ?? '';

    // Validar datos obligatorios
    if (empty($nombre) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || empty($icono)) {
        echo 'error 1';
        exit();
    }

    try {
        $query = "INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin, icono)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nombre, $descripcion, $fechaInicio, $fechaFin, $icono]);

        echo 'success';
    } catch (PDOException $e) {
        echo 'error 2';
    }

    exit();
}

// Si no es POST
echo 'error 3';
exit();
?>
