<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$departamento=$_POST['Departamento'];
        $matricula=$_POST['Matricula'];
		// Conexión a la base de datos
		include("conexion.php");
		if ($conecta->connect_error) {
			die("Conexión fallida: " . $conecta->connect_error);
		}

		$query = "SELECT * FROM Especialidades WHERE MatriculaDepto = '$matricula' OR NombreDepto = '$departamento'";
		$result = $conecta->query($query);
		if ($result->num_rows > 0) {
    		// El departamento ya está registrado
    		echo "existe";
			exit;
		}
		// Insertar los datos en la tabla "Departamento"
	    $sql="INSERT INTO Especialidades (MatriculaDepto, NombreDepto) VALUES ('$matricula','$departamento')";
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