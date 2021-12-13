<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_logistic'])){
 
 $idcita = idDepartamento($_GET['id']);
 
 if (!$idcita) {
  	header('Location: ' . RUTA . '/admin');
  }
  
  $conexion = conexion($bd_config);
  
  	$statement = $conexion->prepare("SELECT * FROM rel_citas
		WHERE id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
 
 if ($cita['relaci_asistencia'] == 0) {
   $statement = $conexion->prepare("UPDATE rel_citas SET relaci_asistencia = :estatus WHERE id_cita = :idCita");
			$statement->execute(array(':estatus' => 1, ':idCita' => $idcita));
 } else {
   $statement = $conexion->prepare("UPDATE rel_citas SET relaci_asistencia = :estatus WHERE id_cita = :idCita");
			$statement->execute(array(':estatus' => 0, ':idCita' => $idcita));
 }
	
 header('Location: index.php');
 
 } else {
	header('Location: ' . RUTA);
}

 ?>