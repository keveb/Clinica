<?php
// Realiza la conexión a la base de datos (ajusta los detalles según tu configuración)
include("conexion.php");
if ($conecta->connect_error) {
	die("Conexión fallida: " . $conecta->connect_error);
}

// Obtén la especialidad seleccionada del POST
$especialidadSeleccionada = $_POST['especialidad'];

// Realiza la consulta para obtener los IDasignado de la especialidad seleccionada
$query = "SELECT IDasignado FROM AsignaDepto WHERE MatriculaDepto = '$especialidadSeleccionada'";
$resultado = mysqli_query($conecta, $query);

// Verifica si hay resultados
if ($resultado) {
    $idasignados = array();

    // Obtén los datos y guárdalos en un array
    while ($row = mysqli_fetch_assoc($resultado)) {
        $idasignados[] = $row;
    }

    // Devuelve los datos en formato JSON
    echo json_encode($idasignados);
} else {
    // En caso de error, devuelve un mensaje de error en formato JSON
    echo json_encode(array('error' => 'Error al obtener los IDasignado'));
}

// Cierra la conexión a la base de datos
mysqli_close($conecta);
?>
