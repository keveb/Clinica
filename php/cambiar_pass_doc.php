<?php
include("conexion.php");

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

$usuario = $_POST["usuario"];
$contra = $_POST['nuevaPass'];
$encrip = password_hash($contra, PASSWORD_DEFAULT);

$sql = "UPDATE Doctores SET passwDoc='$encrip', primerInicio=false WHERE CurpDoc='$usuario'";
if ($conecta->query($sql) === TRUE) {
    echo "ok";
} else {
    echo "error";
}

$conecta->close();
?>