
<?php
include 'conexion.php';

// Función para obtener estudiantes
function obtenerEstudiantes() {
    global $conn;
    $sql = "SELECT * FROM estudiante";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Ejemplo de uso
$estudiantes = obtenerEstudiantes();
foreach ($estudiantes as $estudiante) {
    echo "Nombre: " . $estudiante['Nombre'] . "<br>";
}
?>
