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
		$encrip = password_hash($curp, PASSWORD_DEFAULT);

		// Conexión a la base de datos
		include("conexion.php");
		if ($conecta->connect_error) {
			die("Conexión fallida: " . $conecta->connect_error);
		}

		$query = "SELECT * FROM Doctores WHERE CurpDoc = '$curp'";
		$result = $conecta->query($query);
		if ($result->num_rows > 0) {
    		// El doctor ya está registrado
    		echo "existe";
			exit;
		}
		// Insertar los datos en la tabla "doctores"
	    $sql="INSERT INTO Doctores (CurpDoc, passwDoc, nombresDoc, apellidosDoc, edadDoc, correoDoc, telefonoDoc, direccionDoc, especialidadDoc, cedulaDoc, fecha_registroDoc) VALUES ('$curp','$encrip','$nombres','$apellidos','$edad','$correo','$telefono','$direccion','$especialidad','$cedula', CURRENT_DATE)";
		if ($conecta->query($sql) === TRUE) {
			echo "ok";
		} else {
			echo "error";
		}

		// Obtener la matrícula del departamento
		$sqlDepartamento = "SELECT MatriculaDepto FROM Especialidades WHERE NombreDepto = '$especialidad'";
		$resultadoDepartamento = $conecta->query($sqlDepartamento);
	
		if ($resultadoDepartamento->num_rows > 0) {
			// El departamento fue encontrado, obtenemos la matrícula
			$filaDepartamento = $resultadoDepartamento->fetch_assoc();
			$matriculaDepto = $filaDepartamento["MatriculaDepto"];
	
			// Inserción en la tabla "AsignaDepto"
			$sqlAsignaDepto = "INSERT INTO AsignaDepto (CurpDoc, MatriculaDepto) VALUES ('$curp', '$matriculaDepto')";
			$conecta->query($sqlAsignaDepto);
		}
		$conecta->close();
	} else {
		echo "error";
	}
?>