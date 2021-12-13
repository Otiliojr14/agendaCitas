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
	

	$feriados = consultarDatos('cat_feriados', $conexion);
	$departamentos = consultarDatos('cat_departamentos', $conexion);
	$horarios = consultarDatos('cat_horario_disp', $conexion);

	$fecha_actual = date("Y-m-d");

	$statement = $conexion -> prepare("SELECT id_horario, chd_inicio, chd_fin, chd_fecha, chd_estatus, cat_departamentos.id_departamento ,cat_departamentos.cdep_nombre as departamento_nombre FROM cat_horario_disp
	 INNER JOIN cat_departamentos
	 ON cat_horario_disp.id_departamento = cat_departamentos.id_departamento ");
	$statement->execute();
	$resultado = $statement->fetchAll();

	$datos = $resultado;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$usuario = $_SESSION['matricula'];
		$fecha = limpiarDatos($_POST['fecha_cita']);
		$departamento = limpiarDatos($_POST['departamento_cita']);
		$hora = limpiarDatos($_POST['hora_cita']);
		$motivo = limpiarDatos($_POST['motivo_cita']);

		// echo "<p>$usuario</p>";
		// echo "<p>$fecha</p>";
		// echo "<p>$departamento</p>";
		// echo "<p>$hora</p>";
		// echo "<p>$motivo</p>";

		if (empty($fecha) or empty($departamento) or empty($hora) or empty($motivo)) {
			$errores .= 'Introduce todos los datos';
		} else {
						
			if(!empty($name_user['cal_nombre'])) {
				$nombre = $name_user['cal_nombre_full'];
			} elseif (!empty($name_user['cper_nombre'])) {
				$nombre = $name_user['cper_nombre'];
			}
			
			$statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_departamento = :id_departamento');
			$statement->execute(array(':id_departamento' => $departamento));
			$nombreDepartamento = $statement->fetch();
			
			$statement = $conexion -> prepare('SELECT * FROM cat_horario_disp WHERE id_horario = :hora');
			$statement->execute(array(':hora' => $hora));
			$horaCita = $statement->fetch();
			
			if ($type_user == 1) {
			$correo_alumno = $matricula.'@alumno.ujat.mx';
			$asunto = "Solicitud de cita a la DAMR";
			
			$mail = new PHPMailer(true);
            try{
                    
                    $RemitenteMail = 'computo@damrios.com';
                    $RemitenteNombre = 'Jefatura de Cómputo UJAT - DAMR';
                    $Asunto = 'Solicitud de cita a la DAMR';
                    $Cuerpo = '
                    <h3>Universidad Juárez Autónoma de Tabasco</h3>
					<h4>División Académica Multidisciplinaria de los Ríos</h4>
                    <br>
                    <p>Se ha recibido la solicitud de cita para el departamento: '. $nombreDepartamento['cdep_nombre'] . ' </p>
                    <p>Para la fecha '. cambiaf_a_espanol($fecha) . ' de ' . $horaCita['chd_inicio'] . ' a ' . $horaCita['chd_fin'] . ', a nombre de ' . $nombre . '</p>
                    <p>Se le solicita llegar 5 minutos antes de la hora de su cita, no se permitirá el ingreso antes o después
					de la misma, deberá portar en todo momento cubre bocas y/o careta, observe las recomendaciones del personal
					que lo guiará en todo momento en su estadía dentro del campus universitario, si presenta algún síntoma como
					calentura, dolor muscular, gripa, o tos, envié correo electrónico a la dirección de computo.damr@ujat.mx o
					comuníquese al teléfono 9933581500 ext. 6810 para cancelar su cita.
                    </p>';
                                            
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
					$mail -> addCC($correo_alumno);
					$mail -> addCC(utf8_encode($nombreDepartamento['cdep_email']));
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
				
			} elseif ($type_user == 2) {
				
			$statement = $conexion -> prepare('SELECT * FROM Cat_Personal WHERE cper_empleado = :id_profesor');
			$statement->execute(array(':id_profesor' => $matricula));
			$profesor = $statement->fetch();
			
			$correo_profesor = $profesor['cper_correo'];
			$asunto = "Solicitud de cita a la DAMR";
			
			$mail = new PHPMailer(true);
				try{
						
						$RemitenteMail = 'computo@damrios.com';
						$RemitenteNombre = 'Jefatura de Cómputo UJAT - DAMR';
						$Asunto = 'Solicitud de cita a la DAMR';
						$Cuerpo = '
						<h3>Universidad Juárez Autónoma de Tabasco</h3>
						<h4>División Académica Multidisciplinaria de los Ríos</h4>
						<br>
						<p>Se ha recibido la solicitud de cita para el departamento: '. utf8_encode($nombreDepartamento['cdep_nombre']) . ' </p>
						<p>Para la fecha '. cambiaf_a_espanol($fecha) . ', a nombre de ' . utf8_encode($nombre) . '</p>
						<p>Se le solicita llegar 5 minutos antes de la hora de su cita, no se permitirá el ingreso antes o después
						de la misma, deberá portar en todo momento cubre bocas y/o careta, observe las recomendaciones del personal
						que lo guiará en todo momento en su estadía dentro del campus universitario, si presenta algún síntoma como
						calentura, dolor muscular, gripa, o tos, envié correo electrónico a la dirección de computo.damr@ujat.mx o
						comuníquese al teléfono 9933581500 ext. 6810 para cancelar su cita.
						</p>';
												
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
			} elseif ($type_user == 3) {
			$statement = $conexion -> prepare('SELECT * FROM Cat_Personas WHERE cper_curp = :id_externo');
			$statement->execute(array(':id_externo' => $matricula));
			$externo = $statement->fetch();
			
			$correo_externo = $externo['cper_correo'];
			$asunto = "Solicitud de cita a la DAMR";
			
			$mail = new PHPMailer(true);
				try{
						
						$RemitenteMail = 'computo@damrios.com';
						$RemitenteNombre = 'Jefatura de Cómputo UJAT - DAMR';
						$Asunto = 'Solicitud de cita a la DAMR';
						$Cuerpo = '
						<h3>Universidad Juárez Autónoma de Tabasco</h3>
						<h4>División Académica Multidisciplinaria de los Ríos</h4>
						<br>
						<p>Se ha recibido la solicitud de cita para el departamento: '. $nombreDepartamento['cdep_nombre'] . ' </p>
						<p>Para la fecha '. cambiaf_a_espanol($fecha) . ', a nombre de ' . $nombre . '</p>
						<p>Se le solicita llegar 5 minutos antes de la hora de su cita, no se permitirá el ingreso antes o después
						de la misma, deberá portar en todo momento cubre bocas y/o careta, observe las recomendaciones del personal
						que lo guiará en todo momento en su estadía dentro del campus universitario, si presenta algún síntoma como
						calentura, dolor muscular, gripa, o tos, envié correo electrónico a la dirección de computo.damr@ujat.mx o
						comuníquese al teléfono 9933581500 ext. 6810 para cancelar su cita.
						</p>';
												
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
						$mail -> addCC($correo_externo);
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
			
			$statement = $conexion->prepare("INSERT INTO rel_citas
				(id_cita , id_departamento, id_horario, clave_usuario, relaci_fecha, relaci_motivo, relaci_estatus)
				VALUES (null, :departamento, :hora, :usuario, :fecha, :motivo, :estatus)");
			$statement->execute(array(':departamento' => $departamento, ':hora' => $hora,
			':usuario' => $usuario, ':fecha' => $fecha, ':motivo' => $motivo, ':estatus' => 1));
			$statement = $conexion->prepare("UPDATE cat_horario_disp SET chd_estatus = :estatus WHERE id_horario = :idHorario");
			$statement->execute(array(':estatus' => 0, ':idHorario' => $hora));
			$aviso = 'Su cita ya quedó registrada, se ha enviado notificación a su correo, verifiquelo.';
		}
	}



	require 'view/index.view.php';
} elseif (isset($_SESSION['citaDamr_admin'])) {
	header('Location: admin/');
} elseif (isset($_SESSION['citaDamr_department'])) {
	header('Location: department/');
} elseif (isset($_SESSION['citaDamr_logistic'])) {
	header('Location: logistic/');
} else {
	header('Location: login/');
}

 ?>
