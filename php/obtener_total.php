<?php
include("conexion.php");

$queryAdministradores = "SELECT COUNT(*) AS total FROM administradores";
$queryPacientes = "SELECT COUNT(*) AS total FROM pacientes";
$queryDoctores = "SELECT COUNT(*) AS total FROM doctores";
$queryEspecialidades = "SELECT COUNT(*) AS total FROM especialidades";

$resultAdministradores = $conecta->query($queryAdministradores);
$resultPacientes = $conecta->query($queryPacientes);
$resultDoctores = $conecta->query($queryDoctores);
$resultEspecialidades = $conecta->query($queryEspecialidades);

if ($resultAdministradores && $resultPacientes && $resultDoctores && $resultEspecialidades) {
  $rowAdministradores = $resultAdministradores->fetch_assoc();
  $rowPacientes = $resultPacientes->fetch_assoc();
  $rowDoctores = $resultDoctores->fetch_assoc();
  $rowEspecialidades = $resultEspecialidades->fetch_assoc();

  $totales = array(
    "administradores" => $rowAdministradores["total"],
    "pacientes" => $rowPacientes["total"],
    "doctores" => $rowDoctores["total"],
    "especialidades" => $rowEspecialidades["total"]
  );

  echo json_encode($totales);
}

$conecta->close();
?>