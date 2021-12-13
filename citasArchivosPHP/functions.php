<?php

// Conectando con la base de datos
function conexion($bd_config) {
  try {
    $conexion = new PDO("mysql:host=mysql.damrios.com;dbname=".$bd_config['basedatos'],$bd_config['usuario'],$bd_config['pass']);
		mysqli_set_charset($conexion, "utf8");
    return $conexion;
  } catch (PDOException $e) {
    return false;
  }
}

// Redirige a los usuarios si la sessión esta abierta

function comprobarSesion(){
	if (isset($_SESSION['matricula']) || isset($_SESSION['citaDamr_admin']) || isset($_SESSION['citaDamr_department'])) {
		header('Location: ' . RUTA);
	}
}

// Revisa si el usuario existe

function revisarUsuario($conexion, $matricula, $password, $privilegio){
	$statement = $conexion -> prepare('SELECT * FROM cat_usuarios WHERE cusu_matricula = :matricula AND cusu_password = :password AND cusu_tipo_u = :privilegio');
  $statement->execute(array(':matricula' => $matricula, ':password' => $password, ':privilegio' => $privilegio));
  $resultado = $statement->fetch();

	return $resultado;
}


// Verifica si se introdujo todos los datos y redirige al interior según el tipo de usuario

function asignarSesion($resultado, $matricula, $errores, $privilegio){

	if ($privilegio == 4) {
		if ($resultado !== false) {
			$matricula = $resultado['id_usuario'];
			$_SESSION['citaDamr_admin'] = $matricula;
			header('Location: ' . RUTA . '/admin');
	  } else {
	    $errores .= 'Usuario y/o Contraseña Incorrectos';
			return $errores;
	  }
	} else {
		if ($resultado !== false) {
			$matricula = $resultado['id_usuario'];
			$_SESSION['matricula'] = $matricula;
	    header('Location: ' . RUTA);
	  } else {
	    $errores .= 'Usuario y/o Contraseña Incorrectos';
			return $errores;
	  }
	}
}

// Muestra el nombre de usuario dependiendo de la sección abierta

function mostrarUsuarioName($conexion){

	if (isset($_SESSION['matricula'])) {
		$matricula = $_SESSION['matricula'];
	} elseif (isset($_SESSION['citaDamr_admin'])) {
		$matricula = $_SESSION['citaDamr_admin'];
	}	elseif (isset($_SESSION['citaDamr_department'])) {
		$matricula = $_SESSION['citaDamr_department'];
	}

	$statement = $conexion -> prepare('SELECT * FROM cat_usuarios WHERE id_usuario = :id_usuario');
  $statement->execute(array(':id_usuario' => $matricula));
  $name_user = $statement->fetch();

	return $name_user;
}

function mostrarAdminName($conexion){

	if (isset($_SESSION['citaDamr_admin'])) {
		$matricula = $_SESSION['citaDamr_admin'];
	}	elseif (isset($_SESSION['citaDamr_department'])) {
		$matricula = $_SESSION['citaDamr_department'];
	} elseif (isset($_SESSION['citaDamr_logistic'])) {
		$matricula = $_SESSION['citaDamr_logistic'];
	}

	$statement = $conexion -> prepare('SELECT * FROM Cat_Personal WHERE id_personal = :id_usuario');
  $statement->execute(array(':id_usuario' => $matricula));
  $name_user = $statement->fetch();

	return $name_user;
}

// Cambia el formato de la fecha de americano al español
function cambiaf_a_espanol($fecha){
    preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}

function get_nombre_dia($fecha){
		date_default_timezone_set('America/Mexico_City');
   $fechats = strtotime($fecha); //pasamos a timestamp

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch (date('w', $fechats)){
    case 0: return "Domingo"; break;
    case 1: return "Lunes"; break;
    case 2: return "Martes"; break;
    case 3: return "Miercoles"; break;
    case 4: return "Jueves"; break;
    case 5: return "Viernes"; break;
    case 6: return "Sabado"; break;
}
}

function consultarDatos($tabla, $conexion) {
	$statement = $conexion -> prepare("SELECT * FROM $tabla");
  $statement->execute();
	$resultado = $statement->fetchAll();

	return $resultado;
}

function limpiarDatos($datos){
		$datos = trim($datos);
		$datos = stripslashes($datos);
		$datos = htmlspecialchars($datos);
		return $datos;
}

function idDepartamento($id){
		return (int)limpiarDatos($id);
}

function obtenerDepartamentoHorario($conexion,$id){
	$resultado = $conexion->query("SELECT * FROM cat_horario_disp WHERE id_departamento =$id");
	$resultado = $resultado->fetchAll();

	return ($resultado) ? $resultado : false;
}

function zonaHoraria() {
	date_default_timezone_set('America/Mexico_City');
}

function agregarMediaHora($horaInicio) {
	$minutoAnadir = 30;
	$segundos_horaInicio = strtotime($horaInicio);
	$segundos_minutoAnadir = $minutoAnadir * 60;
	$hora_final = date("H:i",$segundos_horaInicio + $segundos_minutoAnadir);
	return $hora_final;
}

function totalPaginas($postPorPagina, $conexion){
	$totalPost = $conexion->prepare("SELECT FOUND_ROWS() AS total");
	$totalPost->execute();
	$totalPost = $totalPost->fetch()['total'];

	$numeroPaginas = ceil($totalPost / $postPorPagina);

	return $numeroPaginas;
}

function paginaActual(){
		return isset($_GET['p']) ? (int)$_GET['p'] : 1;
}
 ?>
