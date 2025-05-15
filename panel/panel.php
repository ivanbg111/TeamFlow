<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Control</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Enlace al CSS de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tus estilos -->
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/panel.css" />
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">(LOGO)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">

                    <!-- Recientes (clic) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="recientesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Recientes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="recientesDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <img src="img/proyA.jpg" class="project-thumb me-2" alt="A">
                                    Proyecto A
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <img src="img/proyB.jpg" class="project-thumb me-2" alt="B">
                                    Proyecto B
                                </a>
                            </li>
                            <!-- ... -->
                        </ul>
                    </li>

                    <!-- Marcados (clic) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="marcadosDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Marcados
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="marcadosDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <img src="img/proyX.jpg" class="project-thumb me-2" alt="X">
                                    Proyecto X
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <img src="img/proyY.jpg" class="project-thumb me-2" alt="Y">
                                    Proyecto Y
                                </a>
                            </li>
                            <!-- ... -->
                        </ul>
                    </li>

                </ul>

                <!-- Buscador -->
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Buscar proyectos" aria-label="Buscar">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>


    <!-- aaa -->

    <div class="d-flex">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="sidebar active">
            <div class="usuario-info">
                <i class="fas fa-user-circle fa-3x"></i>
                <h3>Nombre Usuario</h3>
                <a href="#">Mi Perfil</a>
                <a href="#">Configuración</a>
                <a href="#">Cerrar Sesión</a>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
<?php
include '../config/config.php'; // Incluimos la conexión $pdo

// Consultar los proyectos
$query = "SELECT * FROM proyectos ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main id="contenido" class="contenido">

    <section class="seccion-proyectos mb-5">
        <h2 class="titulo-seccion">Proyectos Recientes</h2>
        <div class="contenedor-cards">
            <?php foreach ($proyectos as $proyecto): ?>
                <a href="tareas.php?id=<?php echo $proyecto['id']; ?>"> <!-- Enlace al proyecto -->
                    <div class="card-proyecto">
                        <div class="card-header">
                            <i class="fas fa-ellipsis-v opciones-card"></i>
                        </div>
                        <div class="card-body">
                            <h4>
                                <?php echo htmlspecialchars($proyecto['nombre']); ?>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <i class="fas fa-star estrella-card"></i>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="seccion-proyectos">
        <h2 class="titulo-seccion">Mis Proyectos</h2>
        <div class="contenedor-cards">
            <?php foreach ($proyectos as $proyecto): ?>
                <a href="tareas.php?id=<?php echo $proyecto['id']; ?>"> <!-- Enlace al proyecto -->
                    <div class="card-proyecto">
                        <div class="card-header">
                            <i class="fas fa-ellipsis-v opciones-card"></i>
                        </div>
                        <div class="card-body">
                            <h4>
                                <?php echo htmlspecialchars($proyecto['nombre']); ?>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <i class="fas fa-star estrella-card"></i>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>

            <!-- Card para crear nuevo proyecto -->
            <div class="card-proyecto card-crear">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <i class="fas fa-plus fa-2x"></i>
                </div>
            </div>
        </div>
    </section>

</main>



    </div>

    <!-- BOTÓN TOGGLE -->
    <button id="sidebarToggle" class="sidebar-toggle">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Modal Crear Proyecto -->
    <div id="modalCrearProyecto" class="modal" style="display: none;">
        <div class="modal-contenido">
            <h2>Crear Nuevo Proyecto</h2>
            <form id="formularioCrearProyecto">
                <div class="mb-3">
                    <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombreProyecto" name="nombreProyecto" required>
                </div>
                <div class="mb-3">
                    <label for="descripcionProyecto" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcionProyecto" name="descripcionProyecto" rows="3"
                        required></textarea>
                </div>
                <div class="mb-3">
                    <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                </div>
                <div class="mb-3">
                    <label for="fechaFin" class="form-label">Fecha de Fin</label>
                    <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
                </div>


                <div class="container-icon">
                    <p>Selecciona un Icono</p>
                    <div class="icon-container">
                        <div class="icon-card" data-icon="fas fa-apple-alt">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-carrot">
                            <i class="fas fa-carrot"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-pizza-slice">
                            <i class="fas fa-pizza-slice"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-football-ball">
                            <i class="fas fa-football-ball"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-bicycle">
                            <i class="fas fa-bicycle"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-bus">
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-plane">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-rocket">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-motorcycle">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div class="icon-card" data-icon="fas fa-train">
                            <i class="fas fa-train"></i>
                        </div>
                    </div>
                    <!-- Campo oculto para almacenar el icono seleccionado -->
                    <input type="hidden" id="selectedIcon" name="selectedIcon" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-cancelar me-2" id="cerrarModal">Cancelar</button>
                    <button type="submit" class="btn btn-crear">Crear</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Enlazar CSS de Flatpickr (en el <head>) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Enlazar JS de Flatpickr (antes de tu propio JS) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->

    <!-- Enlace a Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/panel.js"></script>


</body>

</html>