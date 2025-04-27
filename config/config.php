<?php
// Definir las constantes de la conexión a la base de datos
define('DB_HOST', 'localhost');    // Dirección del servidor de base de datos
define('DB_USER', 'root');         // Nombre de usuario de la base de datos
define('DB_PASSWORD', '');         // Contraseña de la base de datos (por defecto está vacía en XAMPP)
define('DB_NAME', 'teamflow');  // Nombre de la base de datos

// Crear la conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    // Configurar el modo de error de PDO a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error en la conexión, se muestra el mensaje
    die("Error de conexión: " . $e->getMessage());
}
?>
