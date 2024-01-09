<?php
include("conexion.php");
// Obtener el valor de usuario de la solicitud POST
$usuario = $_POST['usuario'];

if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Consulta para obtener los datos de las citas para un usuario específico
$sql = "SELECT c.IDcita, c.CurpPac, c.FechaCita, c.Hora, a.CurpDoc, d.NombresDoc, c.EstatusCita
        FROM citas c
        INNER JOIN asignadepto a ON c.IDasignado = a.IDasignado
        INNER JOIN doctores d ON a.CurpDoc = d.CurpDoc
        WHERE c.CurpPac = '$usuario'";

$result = $conecta->query($sql);

// Array para almacenar los datos
$datos = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array
    while ($row = $result->fetch_assoc()) {
        // Agregar el nombre del doctor en lugar del IDasignado original
        $row['IDasignado'] = $row['NombresDoc'];

        // Eliminar la columna NombresDoc si no es necesaria
        unset($row['NombresDoc']);

        $datos[] = $row;
    }
}

// Cerrar conexión
$conecta->close();

// Devolver los datos en formato JSON
echo json_encode($datos);
?>