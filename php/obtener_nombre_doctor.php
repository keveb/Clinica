<?php
include("conexion.php");

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

$usuario = $_POST["usuario"];

// Consulta para obtener la información del doctor en base al CURP del doctor
$sql = "SELECT nombresDoc, cedulaDoc FROM Doctores WHERE CurpDoc = '$usuario'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    // Obtener el resultado de la consulta
    $row = $result->fetch_assoc();
    $infoDoctor = array(
        'nombresDoc' => $row["nombresDoc"],
        'cedulaDoc' => $row["cedulaDoc"]
    );
} else {
    $infoDoctor = array(
        'nombresDoc' => "Nombre no encontrado",
        'cedulaDoc' => "Cédula no encontrada"
    );
}

// Cerrar la conexión
$conecta->close();

// Devolver la información del doctor como respuesta en formato JSON
echo json_encode($infoDoctor);
?>
