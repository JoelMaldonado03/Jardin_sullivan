<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// --- Crear usuario ---
if (isset($_POST['crear_usuario'])) {
    $nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar contraseña
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);

    $sql = "INSERT INTO usuario (Nombre_Usuario, Contraseña, email, Rol) VALUES ('$nombre_usuario', '$contraseña', '$email', '$rol')";
    if (mysqli_query($conn, $sql)) {
        echo "Usuario agregado exitosamente.";
    } else {
        echo "Error al agregar usuario: " . mysqli_error($conn);
    }
}

// --- Actualizar usuario ---
if (isset($_POST['editar_usuario'])) {
    $id = intval($_POST['id']);
    $nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);

    $sql = "UPDATE usuario SET Nombre_Usuario = '$nombre_usuario', email = '$email', Rol = '$rol' WHERE ID_Usuario = $id";
    if (mysqli_query($conn, $sql)) {
        echo "Usuario actualizado exitosamente.";
    } else {
        echo "Error al actualizar usuario: " . mysqli_error($conn);
    }
}

// --- Eliminar usuario ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM usuario WHERE ID_Usuario = $id";
    if (mysqli_query($conn, $sql)) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error al eliminar usuario: " . mysqli_error($conn);
    }
}

// Obtener todos los usuarios para mostrarlos en la tabla
$sql = "SELECT * FROM usuario";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        form {
            width: 50%;
            margin: 20px auto;
        }
        input, button {
            margin: 5px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Gestión de Usuarios</h2>

    <!-- Formulario para agregar usuario -->
    <form method="POST">
        <h3>Agregar Usuario</h3>
        <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" required>
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <input type="text" name="rol" placeholder="Rol (e.g., admin, usuario)" required>
        <button type="submit" name="crear_usuario">Agregar</button>
    </form>

    <!-- Tabla de usuarios -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['ID_Usuario']; ?></td>
                <td><?php echo $row['Nombre_Usuario']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['Rol']; ?></td>
                <td>
                    <!-- Formulario para editar usuario -->
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['ID_Usuario']; ?>">
                        <input type="text" name="nombre_usuario" value="<?php echo $row['Nombre_Usuario']; ?>" required>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                        <input type="text" name="rol" value="<?php echo $row['Rol']; ?>" required>
                        <button type="submit" name="editar_usuario">Editar</button>
                    </form>

                    <!-- Botón para eliminar usuario -->
                    <a href="?eliminar=<?php echo $row['ID_Usuario']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
