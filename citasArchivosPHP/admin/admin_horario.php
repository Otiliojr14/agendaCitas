<?php

require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

  $conexion = conexion($bd_config);
  $name_user = mostrarAdminName($conexion);

  $id = idDepartamento($_GET['id']);

	zonaHoraria();

  $statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_departamento = :id');
  $statement->execute(array(':id' => $id));
  $departamento = $statement->fetch();

  $horario = obtenerDepartamentoHorario($conexion, $id);

	$DateAndTime = date('Y-m-d H:i');

  $datos_por_pagina = $datos_config['datos_por_pagina'];

  $pagina_actual = (isset($_GET['p']) ? (int)$_GET['p'] : 1);
  $inicio = ($pagina_actual > 1) ? $pagina_actual * $datos_por_pagina - $datos_por_pagina : 0;

  if (!$id || empty($departamento)) {
  	header('Location: admin_departamentos.php');
  }

	$statement = $conexion -> prepare("SELECT SQL_CALC_FOUND_ROWS * FROM cat_horario_disp
		WHERE id_departamento = :idDepartamento AND CONCAT(`chd_fecha`,' ',`chd_fin`) > :fechaActual
		LIMIT $inicio, $datos_por_pagina");
	$statement->execute(array(':idDepartamento' => $id , ':fechaActual' => $DateAndTime));
	$horas = $statement->fetchAll();

	if (!$horas && $pagina_actual > 1) {
		header('Location: admin_departamentos.php');
	}

  require 'view/admin_horario.view.php';
} else {
  header('Location: ' . RUTA);
}



 ?>
