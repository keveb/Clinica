<?php
include("conexion.php");

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Obtener el nombre de usuario enviado a través de AJAX
$usuario = $_POST["usuario"];

// Consulta para obtener el nombre completo del usuario en base al nombre de usuario
$sql = "SELECT User FROM Administradores WHERE User = '$usuario'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    // Obtener el resultado de la consulta
    $row = $result->fetch_assoc();
    $nombreCompleto = $row["User"];
} else {
    $nombreCompleto = "Nombre no encontrado";
}

// Cerrar la conexión
$conecta->close();

// Devolver el nombre completo como respuesta
echo $nombreCompleto;
?>