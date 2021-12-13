<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarAdminName($conexion);

	$fecha_actual = date("Y-m-d");

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {


		$diaFestivo = limpiarDatos($_POST['agregar_dia']);

		if (empty($diaFestivo)) {
			$errores .= 'Introduce todos los datos';
		} else {

			$statement = $conexion -> prepare('SELECT * FROM cat_feriados WHERE cfe_fecha = :fecha');
		  $statement->execute(array(':fecha' => $diaFestivo));
		  $resultado = $statement->fetch();

			if ($resultado !== false) {
				$errores = 'Este dia ya esta asignado como festivo.';
			} else {
				$statement = $conexion->prepare("INSERT INTO cat_feriados (id_feriado, cfe_fecha, cfe_estatus) VALUES (null, :diaFestivo, :estatus)");
				$statement->execute(array(':diaFestivo' => $diaFestivo, ':estatus' => 1));
				$aviso = 'Día festivo agregado.';
			}
		}
	}

	require 'view/añadir_dia.view.php';
} else {
	header('Location: ' . RUTA);
}

 ?>
