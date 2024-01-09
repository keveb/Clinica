<?php
include("conexion.php");

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

$usuario = $_POST["usuario"];
$sql = "SELECT CurpDoc, nombresDoc, apellidosDoc, edadDoc, correoDoc, telefonoDoc, direccionDoc, especialidadDoc, cedulaDoc, fecha_registroDoc FROM Doctores WHERE CurpDoc = '$usuario'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    // Obtener los datos del usuario
    $row = $result->fetch_assoc();
    $curp = $row["CurpDoc"];
    $nombre = $row["nombresDoc"];
    $apellidos = $row["apellidosDoc"];
    $edad = $row["edadDoc"];
    $correoElectronico = $row["correoDoc"];
    $telefono = $row["telefonoDoc"];
    $direccion = $row["direccionDoc"];
    $especialidad = $row["especialidadDoc"];
    $cedula = $row["cedulaDoc"];
    $fechaRegistro = $row["fecha_registroDoc"];
    // Crear un array con los datos del usuario
    $datosUsuario = array(
        "curp" => $curp,
        "nombre" => $nombre,
        "apellidos" => $apellidos,
        "edad" => $edad,
        "correo_electronico" => $correoElectronico,
        "telefono" => $telefono,
        "direccion" => $direccion,
        "especialidad" => $especialidad,
        "cedula" => $cedula,
        "fecha_registro" => $fechaRegistro
    );

    // Devolver los datos del usuario en formato JSON
    header('Content-Type: application/json');
    echo json_encode($datosUsuario);
} else {
    echo "No se encontraron datos del usuario.";
}

// Cerrar la conexión a la base de datos
$conecta->close();
?>