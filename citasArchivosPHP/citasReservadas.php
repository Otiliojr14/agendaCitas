<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/xamanekmtz/PHPMailer/src/Exception.php';
require '/home/xamanekmtz/PHPMailer/src/PHPMailer.php';
require '/home/xamanekmtz/PHPMailer/src/SMTP.php';

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
 
 $statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Alumnos as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cal_matricula AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND CONCAT(`relaci_fecha`,' ',`chd_fin`) > :fechaActual");
	$statement->execute(array(':fechaActual' => $DateAndTime));
	$citas = $statement->fetchAll();
    
    
    require 'view/citasReservadas.view.php';
} else {
 header('Location: ' . RUTA);
}