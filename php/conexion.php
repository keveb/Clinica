<?php
		$conecta = new mysqli('localhost','root','12345678','clinica');
		if(mysqli_connect_errno()) 
			{	
				echo "Error en la conexión: ".mysqli_connect_error();
			}
?>