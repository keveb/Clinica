<?php
// Obtener el valor del parámetro "usuario" enviado por AJAX
$usuario = $_POST['usuario'];

include("conexion.php");

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Consulta para verificar si es la primera vez que el usuario inicia sesión
$sql = "SELECT primerInicio FROM Doctores WHERE CurpDoc = '$usuario'";
$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $primerInicio = $row['primerInicio'];

    // Devolver el resultado al JavaScript
    echo $primerInicio;
}

// Cerrar la conexión a la base de datos
$conecta->close();
?>