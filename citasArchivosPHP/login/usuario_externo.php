<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

// Redirige a los usuarios si la sessión esta abierta
comprobarSesion();

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$matricula = filter_var(($_POST['curp_rfc']), FILTER_SANITIZE_STRING);

	#verifica si la matrícula se ingresó

	if (empty($matricula)) {
		$errores .= 'Introduce todos los datos';
	} else {
		// Conectando con la base de datos
		$conexion = conexion($bd_config);

		$statement = $conexion -> prepare('SELECT * FROM Cat_Personas WHERE cper_curp = :matricula LIMIT 1');
		$statement->execute(array(':matricula' => $matricula));
		$resultado = $statement->fetch();


		#verifica si el usuario existe, sino lo registra
		if ($resultado != false) {
			$password = $_POST['password'];

			if (empty($password)) {
				$errores .= 'Introduce todos los datos';
			} else {
				$statement = $conexion -> prepare('SELECT * FROM Cat_Personas WHERE cper_curp = :password LIMIT 1');
				$statement->execute(array(':password' => $password));
				$resultado = $statement->fetch();

				if ($resultado != false) {
					$matricula = $resultado['cper_curp'];
					$_SESSION['matricula'] = $matricula;
					header('Location: ../index.php');
				} else {
					$errores .= 'Datos incorrectos';
				}
			}

		} else {
			
			// print_r($_POST);
			$name = filter_var(($_POST['name']), FILTER_SANITIZE_STRING);
			$apellido_paterno = filter_var(($_POST['apellido_paterno']), FILTER_SANITIZE_STRING);
			$apellido_materno = filter_var(($_POST['apellido_materno']), FILTER_SANITIZE_STRING);
			$genero = filter_var(($_POST['genero']), FILTER_SANITIZE_STRING);
			$fecha_nacimiento = $_POST['fecha_nacimiento'];
			$mail = filter_var(($_POST['mail']), FILTER_SANITIZE_EMAIL);
			$phone = filter_var(($_POST['phone']), FILTER_SANITIZE_STRING);
			$tutor = filter_var(($_POST['tutor']), FILTER_SANITIZE_STRING);

			if (empty($name) or empty($apellido_paterno) or empty($apellido_materno) or empty($genero) or empty($fecha_nacimiento) or empty($mail) or empty($phone) or empty($tutor)) {
				$errores .= 'Introduce todos los datos';
			} else {
				if ($errores == '') {				
					
					$aviso = '';
					$statement = $conexion->prepare('INSERT INTO Cat_Personas
						(id_persona, cper_curp, cper_apat, cper_amat, cper_nombre, cper_fecha_nacimiento, cper_correo, cper_telefono, cper_sexo, cper_tutor, cper_estado)
						VALUES (null, :matricula, :apellido_paterno, :apellido_materno, :name, :fecha_nacimiento, :mail, :phone, :sexo, :tutor, :estado)');
					$statement->execute(array(':matricula' => $matricula, ':apellido_paterno' => $apellido_paterno,
											  ':apellido_materno' => $apellido_materno, ':name' => $name, ':fecha_nacimiento' => $fecha_nacimiento,
											  ':mail' => $mail, ':phone' => $phone, ':sexo' => $genero, ':tutor' => $tutor, ':estado' => 1));
					#modificar para obtener el id de usuario, pedirle que ingrese otra vez al login
					$_SESSION['matricula'] = $matricula;
					// $aviso = 'Ponga sus credenciales nuevamente para acceder';
					header('Location: ' . RUTA);
				}
			}
		}
	}
}

require 'view/usuario_externo.view.php';

 ?>
