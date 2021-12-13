<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/xamanekmtz/PHPMailer/src/Exception.php';
require '/home/xamanekmtz/PHPMailer/src/PHPMailer.php';
require '/home/xamanekmtz/PHPMailer/src/SMTP.php';

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_department'])) {
    
    $id = $_SESSION['citaDamr_department'];

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = (mostrarAdminName($conexion));
    
    $idcita = idDepartamento($_GET['id']);
    
    if (!$idcita) {
  	header('Location: ' . RUTA . '/department');
    }  

	$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Alumnos as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cal_matricula AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
	$type_user = 1;
	
	if(empty($cita)) {
		$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personal as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_empleado AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
	$type_user = 2;
	}
	
	if(empty($cita)) {
		$statement = $conexion->prepare("SELECT * FROM rel_citas as a, Cat_Personas as b, cat_departamentos as c, cat_horario_disp as d
		WHERE a.clave_usuario = b.cper_curp AND a.id_departamento = c.id_departamento AND a.id_horario = d.id_horario AND a.id_cita = $idcita");
	$statement->execute();
	$cita = $statement->fetch();
	$type_user = 2;
	}

	// print_r($cita);

	if (!$cita) {
		header('Location: ' . RUTA . '/department');
	}
	
	//print_r($cita);
	
	$citaUser = $cita;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		// print_r($_POST);
		
		$cita = limpiarDatos($_POST['idCita']);
		
		$horario = $citaUser['id_horario'];
		$departamento = $citaUser['id_departamento'];
		
		$statement = $conexion->prepare("UPDATE rel_citas SET relaci_estatus = :estatus WHERE id_cita = :cita");
		$statement->execute(array(':estatus' => 0, ':cita' => $cita));
		
		$statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_departamento = :id_departamento');
		$statement->execute(array(':id_departamento' => $departamento));
		$nombreDepartamento = $statement->fetch();
		
		if ($type_user == 1) {
			
			$matricula = $citaUser['clave_usuario'];
			
			$correo_alumno = $matricula.'@alumno.ujat.mx';
			$asunto = "Cancelación de la cita";
					
			$mail = new PHPMailer(true);
			try{
						
						$RemitenteMail = 'computo@damrios.com';
						$RemitenteNombre = 'Jefatura de Cómputo UJAT - DAMR';
						$Asunto = 'Cancelación de la cita';
						$Cuerpo = '
						<h3>Universidad Juárez Autónoma de Tabasco</h3>
						<h4>División Académica Multidisciplinaria de los Ríos</h4>
						<br>
						<p>Su cita del departamento de '. utf8_encode($nombreDepartamento['cdep_nombre']) . ' ha sido cancelada.</p>';
												
						$mail -> CharSet = 'UTF-8';
						$mail -> isSMTP();
						$mail -> Host = 'hosto personalizado';
						$mail -> SMTPAuth = true;
						$mail -> Username = 'correo personalizado';
						$mail -> Password = 'seguridad personalizada';
						$mail -> SMTPSecure = 'tls';
						$mail -> Port = 'Puero personalizado';
						//remitente
						$mail -> setFrom($RemitenteMail, $RemitenteNombre);
						//destinatario
						//$mail -> addAddress($correo, $fullName);
						$mail -> addAddress('computo.damr@ujat.mx', 'LIA. Gilberto García Damían');
						//con copia para
						$mail -> addCC($correo_alumno);
						$mail -> addCC($nombreDepartamento['cdep_email']);
						$mail -> addCC('logisticadamr@gmail.com');
						//cambiar la copia a
						//$mail -> addBCC('computo.damr@ujat.mx');
						//$mail -> addBCC('caja.damr@gmail.com');
						//$mail -> addBCC($correo, $fullName);
						//habilitar formato HTML para el cuerpo del correo
						$mail -> isHTML(true);
						//Asunto del correo
						$mail -> Subject = $Asunto;
						//Cuerpo del mensaje
						$mail -> Body = $Cuerpo;
						
						//Y enviamos el correo
						$mail -> send();
						//echo 'El mensaje ha sido enviado...';
					
				} catch (Exception $e){
                echo "El mensaje no pudo ser enviado.";
                echo "Error de correo: ".$mail -> ErrorInfo;
                die();
				}
		} elseif ($type_user == 2) {
			
			$correo_profesor = $citaUser['cper_correo'];
			$asunto = "Solicitud de cita a la DAMR";
			
			$mail = new PHPMailer(true);
				try{
						
						$RemitenteMail = 'computo@damrios.com';
						$RemitenteNombre = 'Jefatura de Cómputo UJAT - DAMR';
						$Asunto = 'Cancelación de la cita';
						$Cuerpo = '
						<h3>Universidad Juárez Autónoma de Tabasco</h3>
						<h4>División Académica Multidisciplinaria de los Ríos</h4>
						<br>
						<p>Su cita ha sido cancelada.</p>';
												
						$mail -> CharSet = 'UTF-8';
						$mail -> isSMTP();
						$mail -> Host = 'smtp.dreamhost.com';
						$mail -> SMTPAuth = true;
						$mail -> Username = 'computo@damrios.com';
						$mail -> Password = 's7?8YX5U';
						$mail -> SMTPSecure = 'tls';
						$mail -> Port = 587;
						//remitente
						$mail -> setFrom($RemitenteMail, $RemitenteNombre);
						//destinatario
						//$mail -> addAddress($correo, $fullName);
						$mail -> addAddress('computo.damr@ujat.mx', 'LIA. Gilberto García Damían');
						//con copia para
						$mail -> addCC($correo_profesor);
						$mail -> addCC($nombreDepartamento['cdep_email']);
						$mail -> addCC('logisticadamr@gmail.com');
						//cambiar la copia a
						//$mail -> addBCC('computo.damr@ujat.mx');
						//$mail -> addBCC('caja.damr@gmail.com');
						//$mail -> addBCC($correo, $fullName);
						//habilitar formato HTML para el cuerpo del correo
						$mail -> isHTML(true);
						//Asunto del correo
						$mail -> Subject = $Asunto;
						//Cuerpo del mensaje
						$mail -> Body = $Cuerpo;
						
						//Y enviamos el correo
						$mail -> send();
						//echo 'El mensaje ha sido enviado...';
					
				}		              
					catch (Exception $e){
					echo "El mensaje no pudo ser enviado.";
					echo "Error de correo: ".$mail -> ErrorInfo;
					die();
				}
		} 			
		$statement = $conexion->prepare("UPDATE cat_horario_disp SET chd_estatus = :estatus WHERE id_horario = :horario");
		$statement->execute(array(':estatus' => 1, ':horario' => $horario));
				
		header('Location: index.php');		
	}

	require 'view/cancelar_cita.view.php';

} else {
	header('Location: ' . RUTA);
}

 ?>
