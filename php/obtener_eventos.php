<?php
include("conexion.php");
if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$resultado = $conecta->query("SELECT c.FechaCita, c.Hora, c.CurpPac 
FROM Citas c
INNER JOIN asignadepto a ON c.IDasignado = a.IDasignado
WHERE c.EstatusCita = 'programada' AND a.CurpDoc = '$usuario'");

$eventos = array();

while ($fila = $resultado->fetch_assoc()) {
    // Combina la fecha y la hora y convierte a formato ISO 8601
    $fechaHora = $fila['FechaCita'] . ' ' . $fila['Hora'];
    $start = date('c', strtotime($fechaHora));
    $end = date('c', strtotime($fechaHora));

    // Crea un array para cada evento
    $evento = array(
        'title' => 'Cita - ' . $fila['CurpPac'],
        'start' => $start,
        'end' => $end,
        'color' => '#3a87ad',
        'curp' => $fila['CurpPac']
    );

    // Agrega el evento al array de eventos
    $eventos[] = $evento;
}

// Convierte el array de eventos a formato de salida JSON sin escapar caracteres especiales
echo json_encode($eventos, JSON_UNESCAPED_UNICODE);

$conecta->close();
?>
