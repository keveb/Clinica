<?php
include("conexion.php");

// Obtener el ID de la cita a cancelar desde la solicitud POST
$idcita = $_POST['idcita'];

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Actualizar el campo EstatusCita en la tabla citas
$sql = "UPDATE citas SET EstatusCita = 'cancelada' WHERE IDcita = $idcita";

if ($conecta->query($sql) === TRUE) {
    // Éxito en la actualización
    echo json_encode(array("success" => true));
} else {
    // Error en la actualización
    echo json_encode(array("success" => false, "error" => $conecta->error));
}

// Cerrar conexión
$conecta->close();
?>