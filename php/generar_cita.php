<?php
$curp = $_POST['curp'];
$idasignado = $_POST['idasignado'];
$hora = $_POST['hora'];
$fecha = $_POST['fecha'];

include("conexion.php");

// Verificar si ya existe una cita para el mismo doctor, fecha y hora
$sqlVerificar = "SELECT COUNT(*) as count FROM Citas WHERE IDasignado = '$idasignado' AND FechaCita = '$fecha' AND Hora = '$hora'";
$resultado = $conecta->query($sqlVerificar);

// Analizar el resultado de la consulta
if ($resultado) {
    $row = $resultado->fetch_assoc();
    if ($row['count'] > 0) {
        // El doctor está ocupado en ese horario, buscar otro doctor disponible en la misma especialidad
        $sqlSegundoDoctor = "SELECT IDasignado FROM AsignaDepto WHERE MatriculaDepto = (SELECT MatriculaDepto FROM AsignaDepto WHERE IDasignado = $idasignado) AND CurpDoc != (SELECT CurpDoc FROM Doctores WHERE IDasignado = $idasignado) AND CurpDoc NOT IN (SELECT CurpDoc FROM Citas WHERE FechaCita = '$fecha' AND Hora = '$hora') ORDER BY RAND() LIMIT 1";
        $resultadoSegundoDoctor = $conecta->query($sqlSegundoDoctor);

        if ($resultadoSegundoDoctor && $resultadoSegundoDoctor->num_rows > 0) {
            $rowSegundoDoctor = $resultadoSegundoDoctor->fetch_assoc();
            $idasignado = $rowSegundoDoctor['IDasignado'];
            
            // Insertar la nueva cita con el segundo doctor disponible
            $sqlInsertarCita = "INSERT INTO Citas (CurpPac, FechaCita, Hora, IDasignado, EstatusCita) VALUES ('$curp', '$fecha', '$hora', $idasignado, 'programada')";
            $resultadoInsercion = $conecta->query($sqlInsertarCita);

            // Verificar el resultado de la inserción
            if ($resultadoInsercion) {
                $response = array("success" => true, "message" => "Cita agendada correctamente con el segundo doctor disponible.");
            } else {
                $response = array("success" => false, "message" => "Hubo un error al agendar la cita con el segundo doctor. Por favor, inténtalo de nuevo.");
            }
        } else {
            $response = array("success" => false, "message" => "Lo sentimos, no hay otro doctor disponible en la misma especialidad en ese horario.");
        }
    } else {
        // El doctor original está disponible, insertar la cita con él
        $sqlInsertarCita = "INSERT INTO Citas (CurpPac, FechaCita, Hora, IDasignado, EstatusCita) VALUES ('$curp', '$fecha', '$hora', $idasignado, 'programada')";
        $resultadoInsercion = $conecta->query($sqlInsertarCita);

        // Verificar el resultado de la inserción
        if ($resultadoInsercion) {
            $response = array("success" => true, "message" => "Cita agendada correctamente.");
        } else {
            $response = array("success" => false, "message" => "Hubo un error al agendar la cita. Por favor, inténtalo de nuevo.");
        }
    }
} else {
    $response = array("success" => false, "message" => "Error al verificar la disponibilidad del horario.");
}

// Cerrar la conexión a la base de datos
$conecta->close();

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>


