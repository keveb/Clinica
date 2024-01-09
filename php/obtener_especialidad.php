<?php
include("conexion.php");
if ($conecta->connect_error) {
    die("Conexión fallida: " . $conecta->connect_error);
}

// Realiza la consulta para obtener las especialidades
$query = "SELECT MatriculaDepto, NombreDepto FROM Especialidades";
$resultado = mysqli_query($conecta, $query);

// Verifica si hay resultados
if ($resultado) {
    $especialidades = array();

    // Obtén los datos y guárdalos en un array
    while ($row = mysqli_fetch_assoc($resultado)) {
        $especialidades[] = $row;
    }

    // Devuelve los datos en formato JSON
    echo json_encode($especialidades);
} else {
    // En caso de error, devuelve un mensaje de error en formato JSON
    echo json_encode(array('error' => 'Error al obtener las especialidades'));
}

// Cierra la conexión a la base de datos
mysqli_close($conecta);
?>
