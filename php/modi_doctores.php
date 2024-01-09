<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$curp=$_POST['CURP'];
        $nombres=$_POST['Nombre'];
        $apellidos=$_POST['Apellidos'];
        $edad=$_POST['Edad'];
        $correo=$_POST['Email'];
        $telefono=$_POST['Telefono'];
        $direccion=$_POST['Direccion'];
        $especialidad=$_POST['Especialidad'];
        $cedula=$_POST['Cedula'];
        
		// Conexión a la base de datos
		include("conexion.php");
		if ($conecta->connect_error) {
			die("Conexión fallida: " . $conecta->connect_error);
		}

		// Update de los datos en la tabla "doctores"
	    $sql="UPDATE Doctores SET nombresDoc='$nombres', apellidosDoc='$apellidos', edadDoc='$edad', correoDoc='$correo', telefonoDoc='$telefono', direccionDoc='$direccion', especialidadDoc='$especialidad', cedulaDoc='$cedula' WHERE CurpDoc='$curp'";
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