<?php
include 'conexion.php';
// Operaciones CRUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        // Agregar estudiante
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $direccion = $_POST["direccion"];
        $telefono = $_POST["telefono"];
        $correo_electronico = $_POST["correo_electronico"];
        $nivel_academico = $_POST["nivel_academico"];

        $sql = "INSERT INTO estudiante (Nombre, Apellido, Fecha_Nacimiento, Dirección, Teléfono, Correo_Electrónico, Nivel_Academico)
                VALUES ('$nombre', '$apellido', '$fecha_nacimiento', '$direccion', '$telefono', '$correo_electronico', '$nivel_academico')";
        $conn->query($sql);
    } elseif (isset($_POST["edit"])) {
        // Editar estudiante
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $direccion = $_POST["direccion"];
        $telefono = $_POST["telefono"];
        $correo_electronico = $_POST["correo_electronico"];
        $nivel_academico = $_POST["nivel_academico"];

        $sql = "UPDATE estudiante SET 
                Nombre='$nombre', 
                Apellido='$apellido', 
                Fecha_Nacimiento='$fecha_nacimiento', 
                Dirección='$direccion', 
                Teléfono='$telefono', 
                Correo_Electrónico='$correo_electronico', 
                Nivel_Academico='$nivel_academico'
                WHERE ID_Estudiante=$id";
        $conn->query($sql);
    } elseif (isset($_POST["delete"])) {
        // Eliminar estudiante
        $id = $_POST["id"];
        $sql = "DELETE FROM estudiante WHERE ID_Estudiante=$id";
        $conn->query($sql);
    }
}

// Mostrar estudiantes con información del usuario relacionado
$sql = "SELECT ID_Estudiante, Nombre AS Nombre_Estudiante, Apellido, Fecha_Nacimiento, Dirección, 
               Teléfono, Correo_Electrónico, Nivel_Academico, Nombre_Usuario, email
        FROM estudiante 
        INNER JOIN usuario ON Correo_Electrónico = email";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Estudiantes</title>
</head>
<body>
    <h1>CRUD de Estudiantes</h1>

    <!-- Formulario para agregar y editar -->
    <form method="POST" action="">
        <input type="hidden" name="id" id="id">
        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>
        <label>Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br>
        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required><br>
        <label>Dirección:</label>
        <input type="text" name="direccion" id="direccion" required><br>
        <label>Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required><br>
        <label>Correo Electrónico:</label>
        <input type="email" name="correo_electronico" id="correo_electronico" required><br>
        <label>Nivel Académico:</label>
        <input type="text" name="nivel_academico" id="nivel_academico" required><br>
        <button type="submit" name="add">Agregar</button>
        <button type="submit" name="edit">Editar</button>
    </form>

    <h2>Lista de Estudiantes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de Nacimiento</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo Electrónico</th>
            <th>Nivel Académico</th>
            <th>Usuario</th>
            <th>Email Usuario</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["ID_Estudiante"]; ?></td>
                <td><?php echo $row["Nombre_Estudiante"]; ?></td>
                <td><?php echo $row["Apellido"]; ?></td>
                <td><?php echo $row["Fecha_Nacimiento"]; ?></td>
                <td><?php echo $row["Dirección"]; ?></td>
                <td><?php echo $row["Teléfono"]; ?></td>
                <td><?php echo $row["Correo_Electrónico"]; ?></td>
                <td><?php echo $row["Nivel_Academico"]; ?></td>
                <td><?php echo $row["Nombre_Usuario"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td>
                    <button onclick="editRecord(<?php echo htmlspecialchars(json_encode($row)); ?>)">Editar</button>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row["ID_Estudiante"]; ?>">
                        <button type="submit" name="delete">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <script>
        function editRecord(record) {
            document.getElementById("id").value = record.ID_Estudiante;
            document.getElementById("nombre").value = record.Nombre_Estudiante;
            document.getElementById("apellido").value = record.Apellido;
            document.getElementById("fecha_nacimiento").value = record.Fecha_Nacimiento;
            document.getElementById("direccion").value = record.Direccion;
            document.getElementById("telefono").value = record.Telefono;
            document.getElementById("correo_electronico").value = record.Correo_Electronico;
            document.getElementById("nivel_academico").value = record.Nivel_Academico;
        }
    </script>
</body>
</html>
