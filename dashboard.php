<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

echo "Bienvenido, " . $_SESSION['nombre_usuario'] . "!";
echo "Rol: " . $_SESSION['rol'];
?>
