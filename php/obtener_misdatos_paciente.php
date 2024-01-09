<?php
include("conexion.php");

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

$usuario = $_POST["usuario"];
$sql = "SELECT CurpPac, nombresPac, apellidosPac, edadPac, correoPac, telefonoPac, direccionPac, fecha_registroPac FROM Pacientes WHERE CurpPac = '$usuario'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    // Obtener los datos del usuario
    $row = $result->fetch_assoc();
    $curp = $row["CurpPac"];
    $nombre = $row["nombresPac"];
    $apellidos = $row["apellidosPac"];
    $edad = $row["edadPac"];
    $correoElectronico = $row["correoPac"];
    $telefono = $row["telefonoPac"];
    $direccion = $row["direccionPac"];
    $fechaRegistro = $row["fecha_registroPac"];

    // Crear un array con los datos del usuario
    $datosUsuario = array(
        "curp" => $curp,
        "nombre" => $nombre,
        "apellidos" => $apellidos,
        "edad" => $edad,
        "correo_electronico" => $correoElectronico,
        "telefono" => $telefono,
        "direccion" => $direccion,
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