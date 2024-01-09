<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$curp=$_POST['CURP'];
        $nombres=$_POST['Nombre'];
        $apellidos=$_POST['Apellidos'];
        $edad=$_POST['Edad'];
        $correo=$_POST['Email'];
        $telefono=$_POST['Telefono'];
        $direccion=$_POST['Direccion'];
		$encrip = password_hash($curp, PASSWORD_DEFAULT);
		// Conexión a la base de datos
		include("conexion.php");
		if ($conecta->connect_error) {
			die("Conexión fallida: " . $conecta->connect_error);
		}

		$query = "SELECT * FROM Pacientes WHERE CurpPac = '$curp'";
		$result = $conecta->query($query);
		if ($result->num_rows > 0) {
    		// El paciente ya está registrado
    		echo "existe";
			exit;
		}
		// Insertar los datos en la tabla "pacientes"
	    $sql="INSERT INTO Pacientes (CurpPac, passwPac, nombresPac, apellidosPac, edadPac, correoPac, telefonoPac, direccionPac, fecha_registroPac) VALUES ('$curp','$encrip','$nombres','$apellidos','$edad','$correo','$telefono','$direccion', CURRENT_DATE)";
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