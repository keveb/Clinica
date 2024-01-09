<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibe los datos del formulario
    $curp = $_POST['curp'];
    $nombresPac = $_POST['nombres'];
    $apellidosPac = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $temp = $_POST['temp'];
    $alergias = $_POST['alergias'];
    $antecNoPato = $_POST['antecNoPato'];
    $tratamientosAct = $_POST['tratamientosAct'];
    $antecedentes = $_POST['antecedentes'];
    $enfermedades = $_POST['enfermedades'];
    $discapacidades = $_POST['discapacidades'];
    $sintomas = $_POST['sintomas'];

    // Datos adicionales del doctor
    $nombresDoc = $_POST['nombresDoc'];
    $apellidosDoc = $_POST['apellidosDoc'];
    $cedulaDoc = $_POST['cedulaDoc'];

    // Conecta con la base de datos
    include("conexion.php");
    if ($conecta->connect_error) {
        die("Conexión fallida: " . $conecta->connect_error);
    }

    $conecta->autocommit(false);

    date_default_timezone_set('America/Mexico_City');
    $fechaActual = (new DateTime())->format("Y-m-d");
    date_default_timezone_set('UTC');
    
    // SQL para actualizar el estado de la cita a 'atendida'
    $sqlActualizarCita = "UPDATE Citas SET EstatusCita = 'atendida' WHERE CurpPac = '$curp' AND FechaCita = '$fechaActual'";
    
    // SQL para insertar en la tabla de Historial
    $sqlHistorial = "INSERT INTO Historial (fechaHistorial, CurpPac, nombresPac, apellidosPac, edadPac, correoPac, telefonoPac, AlturaPac, Peso, Temperatura, Alergias, AntecedentesFam, Enfermedades, Discapacidades, Sintomas, AntecNoPato, TratamientosAct, nombresDoc, apellidosDoc, cedulaDoc) 
        VALUES (CURRENT_TIMESTAMP, '$curp', '$nombresPac', '$apellidosPac', '$edad', '$correo', '$telefono', '$altura', '$peso', '$temp', '$alergias', '$antecedentes', '$enfermedades', '$discapacidades', '$sintomas', '$antecNoPato', '$tratamientosAct', '$nombresDoc', '$apellidosDoc', '$cedulaDoc')";
    
    // Ejecuta la consulta para actualizar el estado de la cita
    if (!$conecta->query($sqlActualizarCita)) {
        $conecta->rollback(); // Deshace la transacción si hay un error
    
        $response = array("result" => "error", "message" => "Error al actualizar el estado de la cita");
        echo json_encode($response);
    
        // Agregar log para visualizar el error
        error_log('Error en la actualización del estado de la cita: ' . $conecta->error);
    } else {
        // Ejecuta la consulta para insertar en la tabla de Historial
        if (!$conecta->query($sqlHistorial)) {
            $conecta->rollback(); // Deshace la transacción si hay un error
    
            $response = array("result" => "error", "message" => "Error al registrar el diagnóstico");
            echo json_encode($response);
    
            // Agregar log para visualizar el error
            error_log('Error en la inserción del historial: ' . $conecta->error);
        } else {
            $conecta->commit(); // Confirma la transacción si todo está bien
    
            $response = array("result" => "ok", "message" => "Diagnóstico registrado correctamente");
            echo json_encode($response);
        }
    }
    
    // Cierra la conexión a la base de datos
    $conecta->close();
    

}
?>



