<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])){

	$id = $_SESSION['citaDamr_admin'];

	$conexion = conexion($bd_config);
  $name_user = mostrarAdminName($conexion);

  $idcita = idDepartamento($_GET['id']);

	$statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_usuario = :id_usuario');
  $statement->execute(array(':id_usuario' => $id));
  $departamento = $statement->fetch();

	if (!$idcita) {
  	header('Location: ' . RUTA . '/admin');
  }

	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Alumnos as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cal_matricula AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
	
	if(empty($cita)) {
		$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personal as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_empleado AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
	}
	
	if(empty($cita)) {
		$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personas as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_curp AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
	}

	// print_r($cita);

	if (!$cita) {
		header('Location: ' . RUTA . '/admin');
	}

	require 'view/detalle_cita.view.php';
} else {
	header('Location: ' . RUTA);
}


 ?>
