-- Crear base de datos
CREATE DATABASE IF NOT EXISTS teamflow;
USE teamflow;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de equipos
CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Relación usuarios-equipos
CREATE TABLE usuarios_equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_equipo INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_equipo) REFERENCES equipos(id) ON DELETE CASCADE
);

-- Tabla de proyectos
CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    id_equipo INT,
    FOREIGN KEY (id_equipo) REFERENCES equipos(id) ON DELETE SET NULL
);

-- Relación usuarios-proyectos con rol dentro del proyecto
CREATE TABLE usuarios_proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_proyecto INT NOT NULL,
    rol ENUM('admin', 'jefe', 'usuario') DEFAULT 'usuario',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id) ON DELETE CASCADE
);

-- Tabla de tareas
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    estado ENUM('pendiente', 'en_progreso', 'completada') DEFAULT 'pendiente',
    prioridad ENUM('baja', 'media', 'alta') DEFAULT 'media',
    fecha_limite DATE,
    id_proyecto INT NOT NULL,
    id_responsable INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_responsable) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabla de mensajes (chat interno por proyecto)
CREATE TABLE mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT NOT NULL,
    id_usuario INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de notas colaborativas (apuntes dentro del proyecto)
CREATE TABLE notas_colaborativas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT NOT NULL,
    id_usuario INT NOT NULL,
    contenido TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- (OPCIONAL) Tabla de archivos subidos
-- La dejo comentada por si luego quieres activarla fácilmente.
-- CREATE TABLE archivos (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     id_proyecto INT NOT NULL,
--     id_usuario INT NOT NULL,
--     nombre_archivo VARCHAR(255) NOT NULL,
--     ruta_archivo VARCHAR(500) NOT NULL,
--     fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (id_proyecto) REFERENCES proyectos(id) ON DELETE CASCADE,
--     FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
-- );
