<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$curp=$_POST['CURP'];
        $nombres=$_POST['Nombre'];
        $apellidos=$_POST['Apellidos'];
        $edad=$_POST['Edad'];
        $correo=$_POST['Email'];
        $telefono=$_POST['Telefono'];
        $direccion=$_POST['Direccion'];
		// Conexión a la base de datos
		include("conexion.php");
		if ($conecta->connect_error) {
			die("Conexión fallida: " . $conecta->connect_error);
		}

		// Update de los datos en la tabla "pacientes"
	    $sql="UPDATE Pacientes SET nombresPac='$nombres', apellidosPac='$apellidos', edadPac='$edad', correoPac='$correo', telefonoPac='$telefono', direccionPac='$direccion' WHERE CurpPac='$curp'";
        if ($conecta->query($sql) === TRUE) {
			echo "ok";
		} else {
			echo "error";
		}

		$conecta->close();
	} else {
		echo "error";
	}
?>