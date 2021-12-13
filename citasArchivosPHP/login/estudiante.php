<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

// Redirige a los usuarios si la sessión esta abierta
comprobarSesion();

	$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$matricula = filter_var(($_POST['matricula']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$matricula = strtoupper($matricula);
	$password = strtoupper($password);

	if (empty($matricula) or empty($password)) {
		$errores .= 'Introduce todos los datos';
	} else {

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Revisa si el usuario existe
	$statement = $conexion -> prepare('SELECT * FROM Cat_Alumnos WHERE cal_matricula = :matricula AND cal_matricula = :password');
	$statement->execute(array(':matricula' => $matricula, ':password' => $password));
	$resultado = $statement->fetch();
	
	// Verifica si se introdujo la password y redirige al interior según el tipo de usuario
	
	
	if ($resultado !== false) {
		$matricula = $resultado['cal_matricula'];
		$_SESSION['matricula'] = $matricula;
		header('Location: ' . RUTA);
	} else {
		$errores .= 'Usuario y/o Contraseña Incorrectos';
	}

	}
}

require 'view/estudiante.view.php';


 ?>
