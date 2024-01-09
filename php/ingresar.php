<!DOCTYPE html>
<html>
<head>
	<title>Ingresar</title>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php
	session_start();
	include("conexion.php");
if(isset($_POST['usuario_i']) && isset($_POST['contra_i'])){
    $usuario = $_POST['usuario_i'];
    $contra = $_POST['contra_i'];

    $consulta = "(SELECT User AS usuario, Pass AS contraseña, 'administrador' AS tipo FROM administradores WHERE User='$usuario')
                UNION
                (SELECT CurpDoc AS usuario, PasswDoc AS contraseña, 'doctor' AS tipo FROM doctores WHERE CurpDoc='$usuario')
                UNION
                (SELECT CurpPac AS usuario, PasswPac AS contraseña, 'paciente' AS tipo FROM pacientes WHERE CurpPac='$usuario')";

    $consultar = $conecta->query($consulta);

    if($consultar->num_rows > 0){
        $fila = $consultar->fetch_assoc();
        $contra_BD = $fila['contraseña'];
        $tipo_usuario = $fila['tipo'];

        if (password_verify($contra, $contra_BD) == TRUE) {
			setcookie("usuario", $usuario, time() + (86400 * 30), "/");
            switch ($tipo_usuario) {
                case 'administrador':
                    echo "<script>
                        swal({
                            title: 'Inicio de sesión exitoso',
                            text: 'Bienvenido Administrador',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(function(){
                            window.location.href='../index_admin.html';
                        });
                        </script>";
                    break;
                case 'doctor':
                    echo "<script>
                        swal({
                            title: 'Inicio de sesión exitoso',
                            text: 'Bienvenido Doctor',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(function(){
                            window.location.href='../index_doc.html';
                        });
                        </script>";
                    break;
                case 'paciente':
                    echo "<script>
                        swal({
                            title: 'Inicio de sesión exitoso',
                            text: 'Bienvenido Paciente',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(function(){
                            window.location.href='../index_pac.html';
                        });
                        </script>";
                    break;
                default:
                    echo "<script>
                        swal({
                            title: 'Tipo de usuario desconocido',
                            text: 'Inténtalo de nuevo.',
                            icon: 'error',
                            button: 'Aceptar'
                        }).then(function(){
                            window.location.href='../login.html';
                        });
                        </script>";
                    break;
            }
        } else {
            echo "<script>
                swal({
                    title: 'Contraseña incorrecta',
                    text: 'Inténtalo de nuevo.',
                    icon: 'error',
                    button: 'Aceptar'
                }).then(function(){
                    window.location.href='../login.html';
                });
                </script>";
        }
    } else {
        echo "<script>
            swal({
                title: 'Usuario no encontrado',
                text: 'Inténtalo de nuevo.',
                icon: 'error',
                button: 'Aceptar'
            }).then(function(){
                window.location.href='../login.html';
            });
            </script>";
    }
}
	
?>
</body>
</html>