<?php
// Verificar si se recibió el CURP y el nuevo estado
$curp = $_POST['curp'];
$nuevoEstado = $_POST['estado'];

include("conexion.php");
if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Preparar la consulta de actualización del estado
$sql = "UPDATE Pacientes SET estatusPac = '$nuevoEstado' WHERE CurpPac = '$curp'";

// Ejecutar la consulta de actualización del estado
if ($conecta->query($sql) === TRUE) {
    echo "ok"; // Envía la respuesta "ok" si la actualización fue exitosa
} else {
    echo "error"; // Envía la respuesta "error" si hubo un error en la actualización
}

// Cerrar la conexión a la base de datos
$conecta->close();
?>