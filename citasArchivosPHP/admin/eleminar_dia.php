<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarUsuarioName($conexion);

	$idfestivo = idDepartamento($_GET['id']);

	if (!$idfestivo) {
  	header('Location: ' . RUTA . '/admin');
  }

	$statement = $conexion -> prepare('SELECT * FROM cat_feriados WHERE id_feriado = :id');
  $statement->execute(array(':id' => $idfestivo));
  $festivo = $statement->fetch();

	// print_r($festivo);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$diaFestivo = limpiarDatos($_POST['id']);

		$statement = $conexion->prepare('DELETE FROM cat_feriados WHERE id_feriado = :id');
		$statement->execute(array(':id' => $diaFestivo));

		header('Location: admin_festivos.php');
	}
	require 'view/eleminar_dia.view.php';

} else {
	header('Location: ' . RUTA);
}


 ?>
