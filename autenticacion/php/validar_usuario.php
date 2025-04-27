<?php
// Incluir la configuración de la base de datos
include '../../config/config.php';  // Asegúrate de que la ruta sea correcta

// Obtén los datos del formulario
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Cifra la contraseña

// Respuesta inicial
$response = ['status' => 'error', 'errors' => []];

// Verifica si el correo ya existe
$query = "SELECT * FROM usuarios WHERE correo = ? OR usuario = ?"; // Consultamos ambos campos
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $email);
$stmt->bindParam(2, $usuario);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch();
    
    // Verificamos si el correo ya está en uso
    if ($user['correo'] == $email) {
        $response['errors'][] = 'email_existente';  // El correo ya está en uso
    }

    // Verificamos si el usuario ya está en uso
    if ($user['usuario'] == $usuario) {
        $response['errors'][] = 'usuario_existente';  // El nombre de usuario ya está en uso
    }

    // Si hay errores, enviamos la respuesta con los errores
    echo json_encode($response);
    exit();
}

// Si todo está bien, insertamos el nuevo usuario en la base de datos
$query = "INSERT INTO usuarios (nombre, usuario, correo, contraseña) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $nombre);
$stmt->bindParam(2, $usuario);
$stmt->bindParam(3, $email);
$stmt->bindParam(4, $password);
$stmt->execute();

// Si se inserta correctamente, actualizamos la respuesta
$response['status'] = 'success';
echo json_encode($response);
?>
