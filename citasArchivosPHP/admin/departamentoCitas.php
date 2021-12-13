<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	zonaHoraria();

	$DateAndTime = date('Y-m-d H:i');

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarAdminName($conexion);
	
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
	
	
	// print_r($citasExterno);

	require 'view/departamentoCitas.view.php';

} else {
	header('Location: ' . RUTA);
}


 ?>
