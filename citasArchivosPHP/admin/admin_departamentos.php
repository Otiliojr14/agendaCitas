<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

$errores = '';

// Conectando con la base de datos
$conexion = conexion($bd_config);

require_once('../templates/funciones/bd_conexion.php');
require_once('../templates/funciones/horario.php');
require_once('../templates/funciones/calculo_citas.php');

if (isset($_SESSION['citaDamr_admin'])) {

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarAdminName($conexion);

	$fecha_actual = date("d/m/Y");
	
	$statement = $conexion -> prepare('SELECT * FROM cat_departamentos');
	$statement->execute(array(':id' => $id));
	$departamentos = $statement->fetchAll();

	require 'view/admin_departamentos.view.php';

} else {
	header('Location: ' . RUTA);
}

 ?>
