<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

// Redirige a los usuarios si la sessión esta abierta
comprobarSesion();

$errores = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		
    $noEmpleado = filter_var(($_POST['no_prof']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
		

		if (empty($noEmpleado) or empty($password)) {
			$errores .= 'Introduce todos los datos';
		} else {

		// Conectando con la base de datos
		$conexion = conexion($bd_config);

		// Revisa si el usuario existe
		$statement = $conexion -> prepare('SELECT * FROM Cat_Personal WHERE cper_empleado = :noEmpleado AND cper_empleado = :password');
		$statement->execute(array(':noEmpleado' => $noEmpleado, ':password' => $password));
		$resultado = $statement->fetch();
		
		
		
		

		// Verifica si se introdujo la password y redirige al interior según el tipo de usuario
		if ($resultado !== false) {
			$matricula = $resultado['cper_empleado'];
			$_SESSION['matricula'] = $matricula;
			header('Location: ' . RUTA);
		} else {
			$errores .= 'Usuario y/o Contraseña Incorrectos';
		}
	}
}

require 'view/profesor.view.php';

 ?>
