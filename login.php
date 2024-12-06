<?php
include 'conexion.php';
    $consulta="INSERT INTO usuario(ID_Usuario, email, Nombre_Usuario, Contraseña VALUES ($_REQUEST[nombre_usuario], $_REQUEST[contraseña])
    $registros=mysqli_query($con, $consulta) or 
    die("Problemas en el select: " . mysqli_error($con));
    while($reg=mysqli_fetch_array($registros)) {
        echo "Codigo: " . $reg['cedula'] . "<br>";
        echo "Nombre: " . $reg['nombreU'] . "<br>";
        echo "Fecha: " . $reg['fechaC'] . "<br>";
        echo "Tipo Pago: " . $reg['nombreP'] . "<br>";  
        echo "Contrato: " . $reg['valorC'] . "<br>";
        echo "Comision P: " . $reg['valorC'] * $reg['comisionP']. "<br>";
        echo "<hr>";
    } 

?>
