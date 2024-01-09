<?php
// Conecta con la base de datos
include("conexion.php");
if ($conecta->connect_error) {
	die("Conexión fallida: " . $conecta->connect_error);
}

// Obtén el CURP del usuario desde la solicitud POST
$curpUsuario = $_POST['curpUsuario'];

// Prepara y ejecuta la consulta SQL para obtener los historiales del paciente
$sql = "SELECT IDexpediente, fechaHistorial FROM Historial WHERE CurpPac = ?";
$stmt = $conecta->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $curpUsuario);
    $stmt->execute();
    $stmt->bind_result($idExpediente, $fechaHistorial);

    $historiales = array();

    // Recorre los resultados y los agrega al array de historiales
    while ($stmt->fetch()) {
        $historiales[] = array(
            'IDexpediente' => $idExpediente,
            'FechaHistorial' => $fechaHistorial
        );
    }

    // Cierra la declaración preparada
    $stmt->close();

    // Devuelve los datos en formato JSON
    echo json_encode($historiales);
} else {
    // En caso de error en la preparación de la consulta
    echo "error";
}

// Cierra la conexión a la base de datos
$conecta->close();
?>
