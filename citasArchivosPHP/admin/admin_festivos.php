<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

$errores = '';

// Conectando con la base de datos
$conexion = conexion($bd_config);

zonaHoraria();

$datos_por_pagina = $datos_config['datos_por_pagina'];

$pagina_actual = (isset($_GET['p']) ? (int)$_GET['p'] : 1);
$inicio = ($pagina_actual > 1) ? $pagina_actual * $datos_por_pagina - $datos_por_pagina : 0;

if (!$conexion) {
  die();
}

$fecha_actual = date("Y-m-d");

$statement = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM cat_feriados WHERE cfe_fecha >= :fechaActual LIMIT $inicio, $datos_por_pagina");
$statement->execute(array(':fechaActual' => $fecha_actual));
$dias = $statement->fetchAll();

/* if (!$dias) {
  header('Location: admin_festivos.php');
} */


$statement = $conexion->prepare("SELECT FOUND_ROWS() as total_filas");
$statement->execute();
$total_datos = $statement->fetch()['total_filas'];

$total_paginas = ceil($total_datos/$datos_por_pagina);

if (isset($_SESSION['citaDamr_admin'])) {

		// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarAdminName($conexion);

	require 'view/admin_festivos.view.php';
} else {
	header('Location: ' . RUTA);
}


 ?>
