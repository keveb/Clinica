<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombres=$_POST['Nombre'];
        $contra=$_POST['password'];
		$encrip = password_hash($contra, PASSWORD_DEFAULT);
		// Conexión a la base de datos
		include("conexion.php");
		if ($conecta->connect_error) {
			die("Conexión fallida: " . $conecta->connect_error);
		}

		$query = "SELECT * FROM Administradores WHERE User = '$nombres'";
		$result = $conecta->query($query);
		if ($result->num_rows > 0) {
    		// El administrador ya está registrado
    		echo "existe";
			exit;
		}
		// Insertar los datos en la tabla "administradores"
	    $sql="INSERT INTO Administradores (User, Pass) VALUES ('$nombres','$encrip')";
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