<?php
// consulta_paciente.php
include("conexion.php");

// Verificar la conexión
if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Obtener el CURP del formulario
$curp = $_POST['curp'];

// Consultar la información del paciente en la base de datos
$sql = "SELECT * FROM Pacientes WHERE CurpPac = '$curp'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    // Si se encontró el paciente, devuelve los datos en formato JSON
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    // Si no se encontró el paciente, devuelve un objeto vacío
    echo json_encode(array());
}

// Cerrar la conexión
$conecta->close();
?>
