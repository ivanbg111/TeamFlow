<?php
// panel/php/tasks.php
include __DIR__ . '/../../config/config.php';
header('Content-Type: application/json');

$response = ['ok' => false];

try {
    $act = $_POST['action'] ?? '';
    // Para add-list:
    $proyectoId = $_POST['proyecto_id'] ?? null;
    $listaId    = $_POST['lista_id']    ?? null;
    $nombre     = $_POST['nombre']      ?? null;
    $titulo     = $_POST['titulo']      ?? null;

    error_log("POST recibido. Acción: $act, proyecto_id: $proyectoId, lista_id: $listaId, nombre: $nombre, titulo: $titulo");

    if ($act === 'add-list') {
        if (!$proyectoId || !$nombre) {
            throw new Exception("Faltan datos para crear la lista");
        }

        // Calcula el próximo orden dentro del proyecto
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(orden), -1) + 1 FROM listas WHERE proyecto_id = ?");
        $stmt->execute([$proyectoId]);
        $orden = (int) $stmt->fetchColumn();

        $q = $pdo->prepare("INSERT INTO listas (proyecto_id, nombre, orden) VALUES (?, ?, ?)");
        $q->execute([$proyectoId, $nombre, $orden]);

        $response = ['ok' => true, 'id' => $pdo->lastInsertId()];
    }
    elseif ($act === 'add-card') {
        if (!$listaId || !$titulo) {
            throw new Exception("Faltan datos para crear la tarjeta");
        }

        // Asegurarse de que la lista exista
        $check = $pdo->prepare("SELECT COUNT(*) FROM listas WHERE id = ?");
        $check->execute([$listaId]);
        if ($check->fetchColumn() == 0) {
            throw new Exception("La lista indicada no existe");
        }

        // Calcula el próximo orden dentro de la lista
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(orden), -1) + 1 FROM tareas WHERE lista_id = ?");
        $stmt->execute([$listaId]);
        $ordenTask = (int) $stmt->fetchColumn();

        $q = $pdo->prepare("INSERT INTO tareas (titulo, lista_id, orden) VALUES (?, ?, ?)");
        $q->execute([$titulo, $listaId, $ordenTask]);

        $response = ['ok' => true, 'id' => $pdo->lastInsertId()];
    }
    else {
        throw new Exception("Acción desconocida: $act");
    }
}
catch (Exception $e) {
    http_response_code(400);
    error_log("Error en tasks.php: " . $e->getMessage());
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
