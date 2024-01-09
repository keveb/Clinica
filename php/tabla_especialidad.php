<?php
include("conexion.php");
if ($conecta->connect_error) {
	die("Conexión fallida: " . $conecta->connect_error);
}

// Consulta para obtener los datos de la tabla en la base de datos
$sql = "SELECT * FROM Especialidades";
$result = $conecta->query($sql);

// Array para almacenar los datos
$datos = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}

// Cerrar conexión
$conecta->close();

// Devolver los datos en formato JSON
echo json_encode($datos);
?>