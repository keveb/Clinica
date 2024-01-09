<?php
// obtener_info_doctor.php

include("conexion.php"); // Asegúrate de tener el archivo de conexión adecuado

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

$usuario = $_POST["usuario"]; // CURP del doctor

// Consulta para obtener la información del doctor en base al CURP
$sql = "SELECT * FROM Doctores WHERE CurpDoc = '$usuario'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    // Obtener el resultado de la consulta
    $row = $result->fetch_assoc();

    // Crear un array asociativo con la información del doctor
    $infoDoctor = array(
        "nombresDoc" => $row["nombresDoc"],
        "apellidosDoc" => $row["apellidosDoc"],
        "cedulaDoc" => $row["cedulaDoc"]
    );

    // Devolver la información del doctor como respuesta en formato JSON
    echo json_encode($infoDoctor);
} else {
    // Si no se encontró el doctor, devolver un objeto vacío
    echo json_encode(array());
}

// Cerrar la conexión
$conecta->close();
?>
