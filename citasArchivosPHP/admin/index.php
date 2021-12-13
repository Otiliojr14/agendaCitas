<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = (mostrarAdminName($conexion));

	require 'view/index.view.php';

} else {
	header('Location: ' . RUTA);
}

 ?>
