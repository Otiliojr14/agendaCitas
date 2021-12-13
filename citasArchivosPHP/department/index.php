<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_department'])) {

	$id = $_SESSION['citaDamr_department'];

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	zonaHoraria();

	$datos_por_pagina = $datos_config['datos_por_pagina'];

  $pagina_actual = (isset($_GET['p']) ? (int)$_GET['p'] : 1);
  $inicio = ($pagina_actual > 1) ? $pagina_actual * $datos_por_pagina - $datos_por_pagina : 0;

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarAdminName($conexion);

	$statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_usuario = :id_usuario');
  $statement->execute(array(':id_usuario' => $id));
  $departamento = $statement->fetch();

	// print_r($departamento);

	$idDepartamento = $departamento['id_departamento'];

	$DateAndTime = date('Y-m-d H:i');

	/*$statement = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM rel_citas
    INNER JOIN cat_departamentos ON rel_citas.id_departamento = cat_departamentos.id_departamento
    INNER JOIN cat_usuarios ON rel_citas.id_usuario = cat_usuarios.id_usuario
    INNER JOIN cat_horario_disp ON rel_citas.id_horario = cat_horario_disp.id_horario
		WHERE rel_citas.id_departamento = :ID AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual
    LIMIT $inicio, $datos_por_pagina");
  $statement->execute(array(':ID' => $idDepartamento, ':fechaActual' => $DateAndTime));

  $citas = $statement->fetchAll();*/
  
  	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Alumnos as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cal_matricula AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_departamento = :ID AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual AND a.relaci_estatus = 1");
	$statement->execute(array(':ID' => $idDepartamento, ':fechaActual' => $DateAndTime));
	$citas = $statement->fetchAll();
	
	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personal as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_empleado AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_departamento = :ID AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual AND a.relaci_estatus = 1");
	$statement->execute(array(':ID' => $idDepartamento, ':fechaActual' => $DateAndTime));
	$citasProfesor = $statement->fetchAll();
	
	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personas as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_curp AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_departamento = :ID AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual AND a.relaci_estatus = 1");
	$statement->execute(array(':ID' => $idDepartamento, ':fechaActual' => $DateAndTime));
	$citasExterno = $statement->fetchAll();

	require 'view/index.view.php';

} else {
	header('Location: ' . RUTA);
}

 ?>
