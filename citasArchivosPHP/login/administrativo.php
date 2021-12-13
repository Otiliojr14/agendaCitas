<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

// Redirige a los usuarios si la sessión esta abierta
comprobarSesion();

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $noEmpleado = filter_var(($_POST['no_adm']), FILTER_SANITIZE_STRING);
  $password = $_POST['password'];

  if (empty($noEmpleado) or empty($password)) {
    $errores .= 'Introduce todos los datos';
  } else {


	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	$statement = $conexion -> prepare('SELECT * FROM cat_departamentos
		INNER JOIN Cat_Personal ON cat_departamentos.id_usuario = Cat_Personal.id_personal
		WHERE cper_empleado = :noEmpleado AND cper_empleado = :password');
  $statement->execute(array(':noEmpleado' => $noEmpleado, ':password' => $password));
  $resultado = $statement->fetch();

	if ($resultado !== false) {
		if ($resultado['id_departamento'] == 1) {
			$matricula = $resultado['id_personal'];
			$_SESSION['citaDamr_admin'] = $matricula;
			header('Location: ' . RUTA . '/admin');
		} elseif ($resultado['id_departamento'] == 18) {
   $matricula = $resultado['id_personal'];
			$_SESSION['citaDamr_logistic'] = $matricula;
			header('Location: ' . RUTA . '/logistic');
  }else {
			$matricula = $resultado['id_personal'];
			$_SESSION['citaDamr_department'] = $matricula;
			header('Location: ' . RUTA . '/department');
		} 
	} else {
		$errores .= 'Usuario y/o Contraseña Incorrectos';
	} 
}
}

require 'view/administrativo.view.php';

 ?>
