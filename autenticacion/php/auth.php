<?php
session_start();
include '../../config/config.php';

$accion = $_POST['accion'] ?? '';
$response = ['status' => 'error', 'errors' => []];

if ($accion === 'registro') {
    $nombre = $_POST['nombre'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = "SELECT usuario, correo FROM usuarios WHERE usuario = ? OR correo = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$usuario, $email]);

    while ($user = $stmt->fetch()) {
        if ($user['usuario'] === $usuario) {
            $response['errors'][] = 'usuario_existente';
        }
        if ($user['correo'] === $email) {
            $response['errors'][] = 'email_existente';
        }
    }

    if (!empty($response['errors'])) {
        echo json_encode($response);
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO usuarios (nombre, usuario, correo, contraseña) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nombre, $usuario, $email, $passwordHash]);

    $response['status'] = 'success';
    echo json_encode($response);
    exit();
}

if ($accion === 'login') {
    $identificador = $_POST['identificador'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE usuario = ? OR correo = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$identificador, $identificador]);
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();

        if (password_verify($password, $user['contraseña'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            $_SESSION['usuario_usuario'] = $user['usuario'];
            $response['status'] = 'success';
        } else {
            $response['errors'][] = 'contraseña_incorrecta';
        }
    } else {
        $response['errors'][] = 'usuario_no_encontrado';
    }

    echo json_encode($response);
    exit();
}

$response['errors'][] = 'accion_invalida';
echo json_encode($response);
exit();
?>
