<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Validar que los campos no estén vacíos
    if (empty($nombre_usuario) || empty($email) || empty($contraseña) || empty($rol)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header('Location: registro.html');
        exit();
    }

    // Verificar si el nombre de usuario ya está en uso
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION['error'] = "El nombre de usuario ya está en uso.";
        header('Location: registro.html');
        exit();
    }

    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuario (nombre_usuario, email, contraseña, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre_usuario, $email, $contraseña_hash, $rol);

    if ($stmt->execute()) {
        $_SESSION['exito'] = "Registro exitoso. Puedes iniciar sesión.";
        header('Location: login.html');
    } else {
        $_SESSION['error'] = "Error al registrar. Intenta nuevamente.";
        header('Location: registro.html');
    }
}
?>