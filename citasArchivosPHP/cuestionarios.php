<?php
require 'admin/config.php';
require 'functions.php';

session_start();

if (isset($_SESSION['matricula'])) {
    zonaHoraria();

	$errores = '';
	$aviso = '';
	// Conectando con la base de datos
	$conexion = conexion($bd_config);
	
	$matricula = $_SESSION['matricula'];

	// Busca el usuario de la sesion y muestra el nombre
	$statement = $conexion -> prepare('SELECT * FROM Cat_Alumnos WHERE cal_matricula = :id_alumno');
	$statement->execute(array(':id_alumno' => $matricula));
	$name_user = $statement->fetch();
	$type_user = 1;
	
	if (empty($name_user)) {
		$statement = $conexion -> prepare('SELECT * FROM Cat_Personal WHERE cper_empleado = :id_profesor');
		$statement->execute(array(':id_profesor' => $matricula));
		$name_user = $statement->fetch();
		$type_user = 2;
	}
	
	if (empty($name_user)) {
		$statement = $conexion -> prepare('SELECT * FROM Cat_Personas WHERE cper_curp = :id_externo');
		$statement->execute(array(':id_externo' => $matricula));
		$name_user = $statement->fetch();
		$type_user = 3;
	}
    
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       print_r($_POST);
       $usuario = $_SESSION['matricula'];
       $fiebre = limpiarDatos($_POST['fiebre']);
       $tos = limpiarDatos($_POST['tos']);
       $olfato = limpiarDatos($_POST['olfato']);
       $gusto = limpiarDatos($_POST['gusto']);
       $fatiga = limpiarDatos($_POST['fatiga']);
       $garganta = limpiarDatos($_POST['garganta']);
       $respiro = limpiarDatos($_POST['respiro']);
       
       if (empty($fiebre) and empty($tos) and empty($olfato) and empty($gusto) and empty($fatiga) and empty($garganta) and empty($respiro)) {
         header('Location: index.php');
       } else {
           $statement = $conexion->prepare("INSERT INTO Cat_Registro_COVID
          (id_registro , creg_fiebre, creg_tos, creg_olfato, creg_gusto, creg_fatiga, creg_garganta, creg_respiro, clave_usuario)
          VALUES (null, :fiebre, :tos, :olfato, :gusto, :fatiga, :garganta, :respiro, :usuario)");
         $statement->execute(array(':fiebre' => $fiebre, ':tos' => $tos,
         ':olfato' => $olfato, ':gusto' => $gusto, ':fatiga' => $fatiga, ':garganta' => $garganta, ':respiro' => $respiro, ':usuario' => $usuario));
       }      
       
   }
   
   
    
	require 'view/cuestionarios.view.php';
} elseif (isset($_SESSION['citaDamr_admin'])) {
	header('Location: admin/');
} elseif (isset($_SESSION['citaDamr_department'])) {
	header('Location: department/');
} else {
	header('Location: login/');
}

 ?>
