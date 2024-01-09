<?php

// Verificar si se recibió el ID del historial
if (isset($_POST['idExpediente'])) {
    $idxp = $_POST['idExpediente'];

    include("conexion.php");
	if ($conecta->connect_error) {
		die("Conexión fallida: " . $conecta->connect_error);
	}

    // Consulta para obtener los detalles del historial
    $sql = "SELECT * FROM Historial WHERE IDexpediente = $idxp";
    $result = $conecta->query($sql);

    if ($result->num_rows > 0) {
        // Convertir el resultado a un array asociativo
        $historial = $result->fetch_assoc();

        // Devolver los detalles como respuesta en formato JSON
        echo json_encode($historial);
    } else {
        // No se encontró el historial con el ID proporcionado
        echo json_encode(['error' => 'Historial no encontrado']);
    }

    // Cerrar la conexión a la base de datos
    $conecta->close();
} else {
    // No se proporcionó el ID del historial
    echo json_encode(['error' => 'ID de historial no proporcionado']);
}

?>
