<?php
// panel/tareas.php

// if (!isset($_GET['proyecto_id'])) {
//     die("Proyecto no especificado");
// }
$proyectoId = (int)$_GET['id'];
include __DIR__ . '/../config/config.php';

// Cargar listas de este proyecto
$stmt = $pdo->prepare("SELECT * FROM listas WHERE proyecto_id = ? ORDER BY orden");
$stmt->execute([$proyectoId]);
$listas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tablero de Tareas</title>
  <link href="../css/tareas.css" rel="stylesheet">
  <link href="../css/panel.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body>
  <div class="container-fluid p-3">
    <h3>Proyecto #<?= $proyectoId ?> – Tablero de Tareas</h3>
    <div id="board" class="d-flex gap-3 overflow-auto mt-4">
      <?php foreach($listas as $lista): ?>
        <div class="list" data-id="<?= $lista['id'] ?>">
          <div class="list-header">
            <h5 contenteditable="true"><?= htmlspecialchars($lista['nombre']) ?></h5>
          </div>
          <ul class="list-tasks mb-2">
            <?php
              $t = $pdo->prepare("SELECT * FROM tareas WHERE lista_id = ? ORDER BY orden");
              $t->execute([$lista['id']]);
              foreach($t->fetchAll() as $tar): ?>
              <li class="task" data-id="<?= $tar['id'] ?>">
                <?= htmlspecialchars($tar['titulo']) ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <button class="btn btn-sm btn-outline-light add-card">Añadir tarjeta</button>
        </div>
      <?php endforeach; ?>
      <div class="list new-list">
        <button class="btn btn-sm btn-primary" id="add-list">+ Añadir otra lista</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script>
    const proyectoId = <?= $proyectoId ?>;
  </script>
  <script src="js/tareas.js"></script>
</body>
</html>
