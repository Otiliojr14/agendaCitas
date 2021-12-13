<?php

require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_logistic'])) {

$conexion = conexion($bd_config);

$name_user = mostrarAdminName($conexion);

	$statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_usuario = :id_usuario');
  $statement->execute(array(':id_usuario' => $id));
  $departamento = $statement->fetch();

zonaHoraria();

	$DateAndTime = date('Y-m-d H:i');

$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Alumnos as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cal_matricula AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual");
	$statement->execute(array(':fechaActual' => $DateAndTime));
	$citas = $statement->fetchAll();
	
	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personal as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_empleado AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual");
	$statement->execute(array(':fechaActual' => $DateAndTime));
	$citasProfesor = $statement->fetchAll();
	
	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personas as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_curp AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual");
	$statement->execute(array(':fechaActual' => $DateAndTime));
	$citasExterno = $statement->fetchAll();
 
 require 'view/index.view.php';
} else {
	header('Location: ' . RUTA);
}

 ?>