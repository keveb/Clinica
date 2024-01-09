<?php
// Obtener la búsqueda enviada por la solicitud AJAX
$busqueda = $_POST['busqueda'];

// Realizar la conexión a la base de datos
include("conexion.php");
if ($conecta->connect_error) {
	die("Conexión fallida: " . $conecta->connect_error);
}

// Escapar caracteres especiales en la búsqueda para evitar inyección de SQL
$busqueda = $conecta->real_escape_string($busqueda);

// Construir la consulta SQL para buscar pacientes
$sql = "SELECT * FROM pacientes WHERE nombresPac LIKE '%$busqueda%' OR apellidosPac LIKE '%$busqueda%'";

// Ejecutar la consulta
$resultado = $conecta->query($sql);

// Verificar si hay error en la consulta
if (!$resultado) {
    die("Error al ejecutar la consulta: " . $conecta->error);
}

// Crear un arreglo para almacenar los resultados de la búsqueda
$pacientes = array();

// Recorrer los resultados de la consulta
while ($fila = $resultado->fetch_assoc()) {
    // Agregar cada fila como un paciente al arreglo
    $pacientes[] = $fila;
}

// Cerrar la conexión a la base de datos
$conecta->close();

// Devolver el resultado como JSON
echo json_encode($pacientes);
?>